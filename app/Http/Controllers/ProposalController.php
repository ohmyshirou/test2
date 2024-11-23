<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\StatusTracking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class ProposalController extends Controller
{
    public function __construct()
{
    $this->middleware(function ($request, $next) {
        $user = Auth::user();

        if ($user) {
            $user->refresh(); // Refresh data user dari database
            $user->load('role'); // Pastikan role dimuat

            Log::info('User check after refresh', [
                'Auth::id()' => Auth::id(),
                'user_id' => $user->id ?? null,
                'role_id' => $user->role->id ?? null,
                'role' => $user->role ?? null,
            ]);

            if (!$user->id || !$user->role || !$user->role->id) {
                Log::error('User data is incomplete after refresh', [
                    'user_id' => $user->id ?? null,
                    'role_id' => $user->role->id ?? null,
                ]);
                return redirect()->route('login')->withErrors('User data is incomplete. Please try again.');
            }
        } else {
            Log::error('No user is logged in');
            return redirect()->route('login')->withErrors('Please log in to access this page.');
        }

        return $next($request); // Pastikan $next($request) diteruskan
    });
}


    public function create()
    {
        return view('student-organization.proposal-submission');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'file' => 'nullable|file|mimes:pdf|max:2048',
            'type' => 'required|in:internal,external',
        ]);

        $facultyId = DB::table('hima')->where('user_id', Auth::id())->value('faculty_id');

        if (!$facultyId) {
            return back()->withErrors('Faculty information is missing. Please contact the administrator.');
        }

        $proposal = new Proposal();
        $proposal->title = $request->input('title');
        $proposal->description = $request->input('description');
        $proposal->event_date = $request->input('event_date');
        $proposal->type = $request->input('type');
        $proposal->submitted_by = Auth::id();
        $proposal->faculty_id = $facultyId;
        $proposal->date_submitted = now();

        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->storeAs('public/proposals', time() . '_' . $request->file('file')->getClientOriginalName());
            $proposal->file_path = str_replace('public/', '', $fileName);
        }

        $proposal->save();

        return redirect()->route('my-proposal')->with('success', 'Proposal submitted successfully!');
    }

    public function proposalApproval()
    {
        $user = Auth::user();
        $user->load('role'); // Paksa muat relasi role


        Log::info('Controller Check: User data', [
            'user' => $user,
            'role_id' => $user->role_id ?? null,
            'role' => $user->roles ?? null,
        ]);

        if (!$user || !$user->role) {
            return redirect()->route('dashboard.admin')->withErrors('You do not have a valid role.');
        }

        // Query untuk mendapatkan semua proposal
        $proposals = Proposal::with(['user', 'faculty', 'latestStatusTracking'])->get();

        // Pastikan view 'admin.proposal-approval' ada
        return view('admin.proposal-approval', compact('proposals'));
    }

    public function approveProposal(Request $request, $id)
    {
        $request->validate(['comment' => 'nullable|string|max:255']);
        $user = Auth::user();
        Log::info('Auth::id() check', [
            'Auth::id()' => Auth::id(),
            'user_id' => $user->id ?? null,
        ]);
        $proposal = Proposal::findOrFail($id);

        // Logika untuk Dekan (hanya fakultasnya)
        if ($user->role->name === 'dekan') {
            $userFaculty = $user->dekan->faculty_id ?? null;
            if ($proposal->faculty_id !== $userFaculty) {
                return redirect()->route('proposal.approval')->withErrors('You can only approve proposals from your faculty.');
            }
        }

        // Logika untuk role lain (Warek, BKAL)
        // Tidak ada pembatasan fakultas

        try {
            Log::info('Approval data before saving to database', [
                'proposal_id' => $proposal->proposal_id,
                'status' => 'Approved',
                'comment' => $request->input('comment', ''),
                'updated_by' => $user->id,
                'role_id' => $user->role->id ?? null,
                'timestamp' => now(),
            ]);

            StatusTracking::create([
                'proposal_id' => $proposal->proposal_id,
                'status' => 'Approved',
                'comment' => $request->input('comment', ''),
                'updated_by' => $user->id,
                'role_id' => $user->role->id,
                'updated_at' => now(),
            ]);

            Log::info('Approval data saved successfully', ['proposal_id' => $proposal->proposal_id]);

            // Periksa apakah semua role yang diperlukan sudah menyetujui
            $this->checkAndFinalizeProposal($proposal);
        } catch (\Exception $e) {
            Log::error('Error while saving approval data', ['error' => $e->getMessage()]);
            return redirect()->route('proposal.approval')->withErrors('An error occurred while saving approval data.');
        }

        return redirect()->route('proposal.approval')->with('success', 'Proposal approved successfully!');
    }

    public function rejectProposal(Request $request, $id)
    {
        $request->validate(['comment' => 'required|string|max:255']);
        $user = Auth::user();

        // Pastikan user memiliki role
        if (!$user->role || !$user->role->id) {
            Log::error('Role ID not found for user', ['user_id' => $user->id]);
            return redirect()->route('proposal.approval')->withErrors('Role ID not found for the current user.');
        }

        $proposal = Proposal::findOrFail($id);

        // Dekan hanya bisa menolak proposal di fakultasnya
        if ($user->role->name === 'dekan') {
            $userFaculty = $user->dekan->faculty_id ?? null;
            if ($proposal->faculty_id !== $userFaculty) {
                Log::error('Faculty mismatch for rejection', ['user_id' => $user->id, 'proposal_id' => $proposal->proposal_id]);
                return redirect()->route('proposal.approval')->withErrors('You can only reject proposals from your faculty.');
            }
        }

        // Warek dan BKA tidak dibatasi oleh fakultas
        // Logic untuk menolak proposal
        try {
            StatusTracking::create([
                'proposal_id' => $proposal->proposal_id,
                'status' => 'Rejected',
                'comment' => $request->input('comment'),
                'updated_by' => $user->id,
                'role_id' => $user->role->id,
                'updated_at' => now(),
            ]);
            Log::info('Proposal rejected successfully', ['proposal_id' => $proposal->proposal_id]);
        } catch (\Exception $e) {
            Log::error('Error rejecting proposal', ['error' => $e->getMessage()]);
            return redirect()->route('proposal.approval')->withErrors('An error occurred while rejecting the proposal.');
        }

        return redirect()->route('proposal.approval')->with('success', 'Proposal rejected successfully!');
    }

    private function checkAndFinalizeProposal($proposal)
    {
        $requiredRoles = $this->getRequiredApprovalRoles($proposal);
        $approvedRoles = StatusTracking::where('proposal_id', $proposal->proposal_id)
            ->where('status', 'Approved')
            ->pluck('role_id')
            ->unique();

        if ($approvedRoles->sort()->values()->toArray() === collect($requiredRoles)->sort()->values()->toArray()) {
            $proposal->status = 'Approved';
            $proposal->save();
            $this->addToCalendar($proposal);
        }
    }

    private function getRequiredApprovalRoles($proposal)
    {
        return $proposal->type === 'external' ? [2, 3, 4] : [3, 4]; // Warek: 2, BKAL: 3, Dekan: 4
    }

    public function addSignature($id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->signature = Auth::user()->name . ' - ' . now();
        $proposal->save();

        return redirect()->route('proposal.approval')->with('success', 'Signature added successfully!');
    }

    public function viewHistory($id)
    {
        $history = StatusTracking::where('proposal_id', $id)->get();
        return view('proposal.history', compact('history'));
    }

    public function downloadApprovalSheet($id)
    {
        $proposal = Proposal::findOrFail($id);
        $pdf = PDF::loadView('approval-sheet', compact('proposal'));
        return $pdf->download("approval_sheet_{$proposal->id}.pdf");
    }

    private function addToCalendar($proposal)
    {
        CalendarEvent::create([
            'title' => $proposal->title,
            'description' => $proposal->description,
            'event_date' => $proposal->event_date,
            'created_by' => Auth::id(),
        ]);
    }
}

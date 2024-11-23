<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\Proposal;
use App\Models\StatusTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Reusable untuk card status count organisasi mahasiswa dan advisor
    private function getProposalStatusCounts($userId = null)
    {
        return [
            'pending' => StatusTracking::when($userId, function ($query) use ($userId) {
                $query->whereHas('proposal', function ($query) use ($userId) {
                    $query->where('submitted_by', $userId); // Filter hanya untuk user tertentu
                });
            })
                ->where('status', 'pending')
                ->count(),

            'approved' => StatusTracking::when($userId, function ($query) use ($userId) {
                $query->whereHas('proposal', function ($query) use ($userId) {
                    $query->where('submitted_by', $userId); // Filter hanya untuk user tertentu
                });
            })
                ->where('status', 'approved')
                ->count(),

            'rejected' => StatusTracking::when($userId, function ($query) use ($userId) {
                $query->whereHas('proposal', function ($query) use ($userId) {
                    $query->where('submitted_by', $userId); // Filter hanya untuk user tertentu
                });
            })
                ->where('status', 'rejected')
                ->count(),
        ];
    }

    // Controller dashboard organisasi mahasiswa
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Mendapatkan parameter pencarian dan penyortiran
        $searchTerm = $request->input('search');
        $sortColumn = $request->input('sort', 'date_submitted'); // Default 'date_submitted'
        $sortDirection = $request->input('direction', 'desc'); // Default 'desc'

        // Mendapatkan proposal dengan filter pencarian dan penyortiran
        $recentProposals = Proposal::where('submitted_by', $user->user_id)
            ->search($searchTerm)
            ->sortBy($sortColumn, $sortDirection)
            ->with('latestStatusTracking') // Memuat status terbaru
            ->paginate(5);

        // Memanggil fungsi reusable untuk card status count
        $statusCounts = $this->getProposalStatusCounts(Auth::id());
        $pendingCount = $statusCounts['pending'];
        $approvedCount = $statusCounts['approved'];
        $rejectedCount = $statusCounts['rejected'];

        // Mengambil data kalender
        $calendarEvents = CalendarEvent::with('proposal', 'user') // Memuat relasi Proposal dan User
            ->whereHas('proposal.statusTrackings', function ($query) {
                $query->where('status', 'Approved');
            })
            ->get()
            ->map(function ($event) {
                return [
                    'title' => $event->proposal->title,
                    'start' => $event->proposal->event_date->format('Y-m-d'),
                    'description' => $event->proposal->description,
                    'created_by' => $event->user->username, // Menampilkan nama pengguna yang membuat event
                ];
            });

        // Jika tidak ada proposal, tampilkan pesan khusus
        $noProposalsMessage = $recentProposals->isEmpty() ? 'No proposals found.' : null;
        return view('student-organization.dashboard', compact('noProposalsMessage', 'pendingCount', 'approvedCount', 'rejectedCount', 'recentProposals', 'calendarEvents'));
    }

    public function dashboard_admin()
    {
        // Mendapatkan jumlah proposal berdasarkan status
        $statusCounts = $this->getProposalStatusCounts(null); // Null untuk semua pengguna
        $pendingCount = $statusCounts['pending'];
        $approvedCount = $statusCounts['approved'];
        $rejectedCount = $statusCounts['rejected'];

        // Mendapatkan data acara kalender
        $calendarEvents = CalendarEvent::with('proposal', 'user') // Memuat relasi Proposal dan User
            ->whereHas('proposal.statusTrackings', function ($query) {
                $query->where('status', 'Approved'); // Hanya proposal yang disetujui
            })
            ->get()
            ->map(function ($event) {
                return [
                    'title' => $event->proposal->title,
                    'start' => $event->proposal->event_date->format('Y-m-d'),
                    'description' => $event->proposal->description,
                    'created_by' => $event->user->username, // Nama pengguna yang membuat event
                ];
            });

        // Mengirimkan data ke view admin dashboard
        return view('admin.dashboard', compact('pendingCount', 'approvedCount', 'rejectedCount', 'calendarEvents'));
    }
}

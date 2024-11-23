<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;

class MyProposalController extends Controller
{
    public function index(Request $request)
    {
        // Get the logged-in user's ID
        $userId = Auth::id();

        // Retrieve search and sort parameters
        $searchTerm = $request->input('search');
        $sortColumn = $request->input('sort', 'date_submitted'); // default sort by date_submitted
        $sortDirection = $request->input('direction', 'desc'); // default descending order

        // Query proposals belonging to the user with search and sort, then paginate the results
        $proposals = Proposal::where('submitted_by', Auth::id())
        ->with('latestStatusTracking')
        ->search(request('search'))
        ->sortBy(request('sort'), request('direction'))
        ->paginate(10);
        return view('student-organization.my-proposal', compact('proposals', 'searchTerm', 'sortColumn', 'sortDirection'));
    }
}

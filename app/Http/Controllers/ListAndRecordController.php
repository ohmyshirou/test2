<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ListAndRecordController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve search, sort, and direction parameters
        $searchTerm = $request->input('search');
        $sortColumn = $request->input('sort', 'username'); // Default sort by 'username'
        $sortDirection = $request->input('direction', 'asc'); // Default direction is ascending

        // Query users with role HIMA and their faculty
        $users = User::with(['role.faculty']) // Include role and faculty relationships
            ->whereHas('role', function ($query) {
                $query->where('name', 'like', '%HIMA%'); // Filter roles containing "HIMA"
            })
            ->where(function ($query) use ($searchTerm) {
                if ($searchTerm) {
                    $query->where('username', 'like', '%' . $searchTerm . '%')->orWhere('email', 'like', '%' . $searchTerm . '%');
                }
            })
            ->when(
                $sortColumn === 'faculty',
                function ($query) use ($sortDirection) {
                    $query
                        ->join('roles', 'users.role_id', '=', 'roles.role_id') // Hubungkan users dengan roles
                        ->join('faculties', 'roles.faculty_id', '=', 'faculties.faculty_id') // Hubungkan roles dengan faculties
                        ->orderBy('faculties.name', $sortDirection); // Urutkan berdasarkan nama fakultas
                },
                function ($query) use ($sortColumn, $sortDirection) {
                    $query->orderBy($sortColumn, $sortDirection); // Sorting default
                },
            )

            ->paginate(4);

        // Pass the data to the view
        return view('student-organization.list-record', compact('users', 'searchTerm', 'sortColumn', 'sortDirection'));
    }
}

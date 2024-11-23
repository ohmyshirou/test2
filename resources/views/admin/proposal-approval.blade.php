@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold mb-6">Proposal Approval</h2>

    {{-- Tampilkan pesan sukses jika ada --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Tabel Proposal --}}
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200 text-left bg-white rounded-lg">
            <thead class="bg-gray-300 text-gray-800 uppercase text-sm font-bold">
                <tr>
                    <th class="py-3 px-6 border-b">#</th>
                    <th class="py-3 px-6 border-b">Title</th>
                    <th class="py-3 px-6 border-b">Description</th>
                    <th class="py-3 px-6 border-b">Type</th>
                    <th class="py-3 px-6 border-b">Faculty</th>
                    <th class="py-3 px-6 border-b">Submitted By</th>
                    <th class="py-3 px-6 border-b">Status</th>
                    <th class="py-3 px-6 border-b">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse ($proposals as $proposal)
                    <tr class="hover:bg-gray-100">
                        <td class="py-4 px-6 border-b text-center">{{ $loop->iteration }}</td>
                        <td class="py-4 px-6 border-b">{{ $proposal->title }}</td>
                        <td class="py-4 px-6 border-b max-w-xs truncate" title="{{ $proposal->description }}">
                            {{ $proposal->description }}
                        </td>
                        <td class="py-4 px-6 border-b">{{ ucfirst($proposal->type) }}</td>
                        <td class="py-4 px-6 border-b">{{ $proposal->faculty->name ?? 'No Faculty Assigned' }}</td>
                        <td class="py-4 px-6 border-b">{{ $proposal->user->username ?? 'Unknown User' }}</td>
                        <td class="py-4 px-6 border-b text-center">
                            @php
                                $statusClasses = [
                                    'Pending' => 'bg-yellow-300 text-gray-800',
                                    'Approved' => 'bg-green-500 text-white',
                                    'Rejected' => 'bg-red-500 text-white',
                                ];
                                $status = $proposal->latestStatusTracking->status ?? 'Pending';
                            @endphp
                            <span class="text-xs font-semibold py-1 px-2 rounded-full {{ $statusClasses[$status] ?? 'bg-gray-300 text-gray-800' }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 border-b space-y-2">
                            @if ($status !== 'Approved')
                            <form action="{{ route('proposal.approve', ['id' => $proposal->proposal_id]) }}" method="POST">
                                @csrf
                                <textarea name="comment" class="w-full p-2 border border-gray-300 rounded-md mb-2" placeholder="Add comment (optional)"></textarea>
                                <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600">
                                    Approve
                                </button>
                            </form>
                            
                            <form action="{{ route('proposal.reject', ['id' => $proposal->proposal_id]) }}" method="POST">
                                @csrf
                                <textarea name="comment" class="w-full p-2 border border-gray-300 rounded-md mb-2" placeholder="Reason for rejection" required></textarea>
                                <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">
                                    Reject
                                </button>
                            </form>
                            
                            
                            @else
                                <a href="{{ route('proposal.addSignature', $proposal->proposal_id) }}" class="w-full inline-block text-center bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                                    Add Signature
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-4 px-6 text-center text-gray-500 italic">
                            <i class="fas fa-folder-open text-gray-400"></i> No proposals pending approval.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

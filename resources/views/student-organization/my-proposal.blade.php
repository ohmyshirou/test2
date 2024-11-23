@extends('layouts.app')
@section('judul', 'My Proposal')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1" y="1" width="34" height="34" rx="6.33333" fill="white" />
                    <rect x="1" y="1" width="34" height="34" rx="6.33333" stroke="#D9D9D9" stroke-width="2" />
                    <path
                        d="M25.4444 13.5556V18.8889C25.4444 22.2409 25.4444 23.9174 24.4026 24.9583C23.3608 25.9992 21.6853 26.0001 18.3333 26.0001H17.4444C14.0924 26.0001 12.4159 26.0001 11.375 24.9583C10.3341 23.9165 10.3333 22.2409 10.3333 18.8889V13.5556"
                        stroke="#6F6F6F" stroke-width="1.33333" stroke-linecap="round" />
                    <path
                        d="M9 11.7778C9 10.9396 9 10.5209 9.26044 10.2604C9.52089 10 9.93956 10 10.7778 10H25C25.8382 10 26.2569 10 26.5173 10.2604C26.7778 10.5209 26.7778 10.9396 26.7778 11.7778C26.7778 12.616 26.7778 13.0347 26.5173 13.2951C26.2569 13.5556 25.8382 13.5556 25 13.5556H10.7778C9.93956 13.5556 9.52089 13.5556 9.26044 13.2951C9 13.0347 9 12.616 9 11.7778Z"
                        stroke="#6F6F6F" stroke-width="1.33333" />
                    <path d="M15.6666 19.2445L16.9368 20.6667L20.1111 17.1111" stroke="#6F6F6F" stroke-width="1.33333"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div style="margin-left: 8px;">
                    <h2 class="text-lg font-semibold">My Proposal's</h2>
                    <p class="text-gray-600">A curated list of proposals that your recently taken on</p>
                </div>
            </div>
            <a href="{{ route('my-proposal') }}">
                <button class="border border-gray-300 font-bold py-2 px-4 rounded-lg">
                    Open My Proposal
                </button>
            </a>
        </div>

        <hr class="my-4 border-gray-300" />

        <form method="GET" action="{{ route('my-proposal') }}">
            <div class="flex items-center mb-4">
                <!-- Input untuk pencarian dengan lebar yang diperlebar -->
                <input type="text" name="search" placeholder="Search Proposal"
                    class="w-full py-2 px-4 border border-gray-300 rounded-lg" value="{{ request('search') }}" />

                <!-- Dropdown untuk kolom sort -->
                <select name="sort" class="ml-4 py-2 px-4 border border-gray-300 rounded-lg">
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                    <option value="date_submitted" {{ request('sort') == 'date_submitted' ? 'selected' : '' }}>Date
                        Submitted</option>
                </select>

                <!-- Dropdown untuk arah sort -->
                <select name="direction" class="ml-4 py-2 px-4 border border-gray-300 rounded-lg">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>

                <!-- Tombol untuk mengaplikasikan filter -->
                <button type="submit"
                    class="ml-4 px-4 py-2 border border-gray-300 hover:bg-gray-100 text-gray-700 font-bold rounded-lg">Apply</button>
            </div>
        </form>

        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="border-b-2 px-4 py-2 text-left">Proposal Name</th>
                    <th class="border-b-2 px-4 py-2 text-left">Comment</th>
                    <th class="border-b-2 px-4 py-2 text-left">Latest Status</th>
                    <th class="border-b-2 px-4 py-2 text-left">Last Upload</th>
                    <th class="border-b-2 px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($proposals as $proposal)
                    @if ($proposal->submitted_by === Auth::id())
                        <tr>
                            <td class="border-b px-4 py-2">{{ $proposal->title }}</td>
                            <td class="border-b px-4 py-2">
                                {{ $proposal->latestStatusTracking?->comment ?? 'No comment' }}
                            </td>
                            <td class="border-b px-4 py-2">
                                {{ $proposal->latestStatusTracking?->status ?? 'No status' }}
                            </td>
                            <td class="border-b px-4 py-2">{{ $proposal->date_submitted->format('Y-m-d') }}</td>
                            <td class="border-b px-4 py-2">
                                <div class="flex space-x-2">
                                    @if ($proposal->file_path)
                                        <a href="{{ asset('storage/' . $proposal->file_path) }}" target="_blank"
                                            class="text-blue-500 hover:underline">Open in Browser</a>
                                    @else
                                        <span class="text-gray-500">No file</span>
                                    @endif
                                    <button class="text-red-500 hover:underline"
                                        onclick="deleteProposal('{{ $proposal->id }}')">Delete Proposal</button>
                                </div>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5" class="border-b px-4 py-2 text-center text-gray-500">No proposals found</td>
                    </tr>
                @endforelse

            </tbody>
        </table>


        <!-- Pagination Controls -->
        <div class="mt-4">
            {{ $proposals->links() }} <!-- Menampilkan link pagination -->
        </div>

    </div>
    </div>

@endsection

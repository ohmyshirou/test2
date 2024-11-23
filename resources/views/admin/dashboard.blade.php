@extends('layouts.admin')

@section('judul', 'Dashboard SI-PROKEG')

@section('content')

    <div class="bg-white p-6 rounded-lg shadow-md mb-4">
        <h2 class="text-xl font-bold">Welcome! {{ Auth::user()->username }}</h2>
    </div>

    <!-- Cards Section -->
    <div class="grid grid-cols-3 gap-6 mb-4">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">{{ $pendingCount }} Proposal Pending</h2>
            <p class="text-gray-600">Proposal that is still on Advisor review</p>
            <button class="mt-4 px-4 py-2 bg-strong-blue text-white rounded-lg">View details</button>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">{{ $approvedCount }} Approved Proposal</h2>
            <p class="text-gray-600">Proposal that is approved by Advisor</p>
            <button class="mt-4 px-4 py-2 bg-strong-blue text-white rounded-lg">View details</button>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">{{ $rejectedCount }} Rejected Proposal</h2>
            <p class="text-gray-600">Proposal that is rejected by Advisor</p>
            <button class="mt-4 px-4 py-2 bg-strong-blue text-white rounded-lg">View details</button>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-4">
        <h2 class="text-xl font-semibold">Upcoming Deadlines</h2>
        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th class="text-left text-gray-600">Proposal</th>
                    <th class="text-left text-gray-600">Deadline</th>
                    <th class="text-left text-gray-600">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2">Event Proposal 2024</td>
                    <td class="py-2">24 November 2024</td>
                    <td class="py-2">Pending</td>
                </tr>
                <tr>
                    <td class="py-2">Annual Report Proposal</td>
                    <td class="py-2">25 November 2024</td>
                    <td class="py-2">Approved</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-2 gap-6 mt-6">
        <!-- Proposal Overview -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">Proposal Overview</h2>
            <div class="flex justify-center">
                <div style="width: 300px; height: 300px;">
                    <canvas id="proposalChart" class="mt-4"></canvas>
                </div>
            </div>
        </div>
    
        <!-- Calendar Organization -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1" y="1" width="34" height="34" rx="7" fill="white" />
                    <rect x="1" y="1" width="34" height="34" rx="7" stroke="#D9D9D9" stroke-width="2" />
                    <path
                        d="M20.7986 8.10639C21.1949 8.00024 21.6082 7.97318 22.0149 8.02676C22.4216 8.08034 22.8138 8.21351 23.169 8.41866C23.5243 8.62381 23.8356 8.89693 24.0853 9.22242C24.335 9.54791 24.5181 9.91939 24.6243 10.3157L27.7116 21.8357C27.8177 22.2319 27.8448 22.6452 27.7912 23.0519C27.7376 23.4586 27.6044 23.8508 27.3993 24.2061C27.1941 24.5613 26.921 24.8727 26.5955 25.1224C26.27 25.372 25.8986 25.5552 25.5023 25.6613L18.3713 27.5718C17.5712 27.7862 16.7186 27.6741 16.0012 27.26C15.2838 26.8459 14.7602 26.1638 14.5457 25.3637L11.4572 13.8425C11.3511 13.4462 11.3241 13.0329 11.3777 12.6261C11.4314 12.2193 11.5647 11.8271 11.7699 11.4718C11.9752 11.1166 12.2484 10.8052 12.574 10.5556C12.8997 10.306 13.2713 10.1229 13.6676 10.0169L20.7986 8.10639Z"
                        fill="#6F6F6F" />
                </svg>
    
                <div class="ml-4">
                    <h2 class="text-lg font-semibold">Calendar Organization</h2>
                    <p class="text-gray-600">Plan your activities effectively!</p>
                </div>
            </div>
    
            <hr class="my-4 border-gray-300" />
    
            <!-- Kalender -->
            <div id="calendar"></div>
    
            <!-- Daftar Acara -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2">Upcoming Events</h3>
                <ul class="list-none">
                    @foreach ($calendarEvents as $event)
                        <li class="mb-4 p-4 bg-gray-100 rounded-lg shadow">
                            <strong class="text-strong-blue">{{ $event['title'] }}</strong>
                            <p class="text-sm text-gray-500">
                                {{ $event['start'] }}<br>
                                Organized by: <span class="font-semibold">{{ $event['created_by'] }}</span>
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    

    <script>
        var ctx = document.getElementById('proposalChart').getContext('2d');
        var proposalChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Pending', 'Approved', 'Rejected'],
                datasets: [{
                    data: [{{ $pendingCount }}, {{ $approvedCount }}, {{ $rejectedCount }}],
                    backgroundColor: ['#fbbf24', '#22c55e', '#ef4444']
                }]
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev', // Tombol sebelumnya
                    center: 'title', // Menampilkan bulan dan tahun (April 2025)
                    right: 'next' // Tombol berikutnya
                },
                events: @json($calendarEvents), // Data acara
                displayEventTime: false, // Tidak menampilkan waktu
                eventDisplay: 'background', // Tampilkan acara sebagai background saja
                height: 'auto', // Sesuaikan tinggi kalender
                eventBackgroundColor: '#007bff', // Warna fill untuk penanda
                eventBorderColor: 'transparent', // Hilangkan border untuk penanda
            });
            calendar.render();
        });
    </script>

@endsection

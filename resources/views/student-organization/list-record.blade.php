@extends('layouts.app')
@section('judul', 'List & Record')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <div style="display: flex; align-items: center;">
            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="1" y="1" width="34" height="34" rx="7" fill="white" />
                <rect x="1" y="1" width="34" height="34" rx="7" stroke="#D9D9D9" stroke-width="2" />
                <path
                    d="M17.9388 17.5722C19.5888 17.5722 20.8721 16.2278 20.8721 14.5778C20.8721 12.9278 19.5277 11.6444 17.8777 11.6444C16.2277 11.6444 14.9443 12.9889 14.9443 14.5778C14.9443 16.2278 16.2888 17.5722 17.9388 17.5722ZM17.8777 12.8667C17.9388 12.8667 17.9388 12.8667 17.8777 12.8667C18.8554 12.8667 19.6499 13.6611 19.6499 14.6389C19.6499 15.6167 18.8554 16.35 17.8777 16.35C16.8999 16.35 16.1666 15.5556 16.1666 14.6389C16.1666 13.6611 16.961 12.8667 17.8777 12.8667Z"
                    fill="#6F6F6F" />
                <path
                    d="M26.9834 17.2056C25.8223 16.1667 24.2945 15.6167 22.7056 15.6778H22.2167C22.0945 16.1667 21.9112 16.5944 21.6667 16.9611C22.0334 16.9 22.339 16.9 22.7056 16.9C23.8667 16.8389 25.0279 17.2056 25.9445 17.8778V22.2778H27.1667V17.3889L26.9834 17.2056Z"
                    fill="#6F6F6F" />
                <path
                    d="M21.2999 11.7667C21.6054 11.0333 22.461 10.6667 23.2554 10.9722C23.9888 11.2778 24.3554 12.1333 24.0499 12.9278C23.8054 13.4778 23.2554 13.8444 22.7054 13.8444C22.5832 13.8444 22.3999 13.8444 22.2777 13.7833C22.3388 14.0889 22.3388 14.3944 22.3388 14.6389V15.0056C22.461 15.0056 22.5832 15.0667 22.7054 15.0667C24.2332 15.0667 25.4554 13.8444 25.4554 12.3778C25.4554 10.85 24.2332 9.62778 22.7666 9.62778C21.7888 9.62778 20.9332 10.1167 20.4443 10.9722C20.7499 11.1556 21.0554 11.4 21.2999 11.7667Z"
                    fill="#6F6F6F" />
                <path
                    d="M14.3333 17.0222C14.0888 16.6556 13.9055 16.2278 13.7833 15.7389H13.2944C11.7055 15.6778 10.1777 16.2278 9.01659 17.2056L8.83325 17.3889V22.2778H10.0555V17.8778C11.0333 17.2056 12.1333 16.8389 13.2944 16.9C13.661 16.9 14.0277 16.9611 14.3333 17.0222Z"
                    fill="#6F6F6F" />
                <path
                    d="M13.2944 15.0056C13.4166 15.0056 13.5389 15.0056 13.6611 14.9445V14.5778C13.6611 14.2722 13.6611 13.9667 13.7222 13.7222C13.6 13.7833 13.4166 13.7833 13.2944 13.7833C12.5 13.7833 11.8277 13.1111 11.8277 12.3167C11.8277 11.5222 12.5 10.85 13.2944 10.85C13.9055 10.85 14.4555 11.2167 14.7 11.7667C14.9444 11.4611 15.3111 11.1556 15.6166 10.9111C14.8222 9.62779 13.1722 9.20001 11.8889 9.99445C10.6055 10.7889 10.1777 12.4389 10.9722 13.7222C11.4611 14.5167 12.3166 15.0056 13.2944 15.0056Z"
                    fill="#6F6F6F" />
                <path
                    d="M22.95 20.8722L22.8278 20.6889C21.6055 19.3444 19.8944 18.55 18.0611 18.6111C16.2278 18.55 14.4555 19.3444 13.2333 20.6889L13.1111 20.8722V25.5167C13.1111 26.0667 13.5389 26.5556 14.15 26.5556H21.9722C22.5222 26.5556 23.0111 26.0667 23.0111 25.5167V20.8722H22.95ZM21.7278 25.3333H14.3333V21.3C15.3111 20.3222 16.6555 19.8333 18.0611 19.8333C19.4055 19.7722 20.75 20.3222 21.7278 21.3V25.3333Z"
                    fill="#6F6F6F" />
            </svg>
            <div style="margin-left: 8px;">
                <h2 class="text-lg font-semibold">List of Organization</h2>
                <p class="text-gray-600">List of student organization on Universitas Pembangunan Jaya</p>
            </div>
        </div>

        <hr class="my-2 border-gray-300" />
        
        <div class="mt-4 flex items-center">
            <form method="GET" action="{{ route('list-record') }}" class="w-full">
                <div class="flex items-center mb-4">
                    <!-- Search Input -->
                    <input type="text" name="search" placeholder="Search Organization"
                        class="w-full py-2 px-4 border border-gray-300 rounded-lg" value="{{ request('search') }}" />

                    <!-- Sort Dropdown -->
                    <select name="sort" class="ml-4 py-2 px-4 border border-gray-300 rounded-lg">
                        <option value="username" {{ request('sort') == 'username' ? 'selected' : '' }}>Name</option>
                        <option value="faculty" {{ request('sort') == 'faculty' ? 'selected' : '' }}>Faculty</option>
                        <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email</option>
                    </select>

                    <!-- Direction Dropdown -->
                    <select name="direction" class="ml-4 py-2 px-4 border border-gray-300 rounded-lg">
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>

                    <!-- Apply Button -->
                    <button type="submit"
                        class="ml-4 px-4 py-2 border border-gray-300 hover:bg-gray-100 text-gray-700 font-bold rounded-lg">Apply</button>
                </div>
            </form>
        </div>

        <table class="min-w-full mt-4">
            <thead>
                <tr>
                    <th class="border-b-2 px-4 py-2 text-left">Name</th>
                    <th class="border-b-2 px-4 py-2 text-left">Role</th>
                    <th class="border-b-2 px-4 py-2 text-left">Faculty</th>
                    <th class="border-b-2 px-4 py-2 text-left">Email</th>
                    <th class="border-b-2 px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
        
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border-b-2 px-4 py-2">{{ $user->username }}</td>
                        <td class="border-b-2 px-4 py-2">{{ $user->role->name }}</td>
                        <td class="border-b-2 px-4 py-2">
                            {{ $user->role->faculty->name ?? 'Not Assigned' }}
                        </td>
                        <td class="border-b-2 px-4 py-2">{{ $user->email }}</td>
                        <td class="border-b-2 px-4 py-2">
                            <a href="{{ route('chat', ['user_id' => $user->user_id]) }}">
                                <button class="border border-gray-300 font-bold py-2 px-4 rounded-lg">
                                    Inbox Organization
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        

        <!-- Pagination Links -->
        <div class="mt-4 flex justify-center">
            {{ $users->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection

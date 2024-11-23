@extends('layouts.admin')

@section('judul', 'Daftar Rekaman')

@section('content')
    <div class="p-6 bg-white shadow rounded-lg">
        <h2 class="text-xl font-bold">List & Record</h2>
        <ul class="mt-4">
            @foreach ($records as $record)
                <li class="mb-2">
                    <a href="{{ route('record.view', $record->id) }}" class="text-blue-500">
                        {{ $record->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

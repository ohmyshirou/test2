@extends('layouts.admin')

@section('judul', 'Arsip Proposal')

@section('content')
<div class="p-6 bg-white shadow rounded-lg">
    <h2 class="text-xl font-bold">Arsip Proposal</h2>
    <table class="table-auto w-full mt-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Judul Proposal</th>
                <th class="px-4 py-2">Tanggal Submit</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($archives as $archive)
                <tr>
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $archive->title }}</td>
                    <td class="border px-4 py-2">{{ $archive->submitted_at }}</td>
                    <td class="border px-4 py-2">{{ $archive->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

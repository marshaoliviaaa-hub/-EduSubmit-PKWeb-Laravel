@extends('layouts.app')

@section('title', $assignment->title)

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.courses.show', $assignment->course) }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali ke {{ $assignment->course->title }}</a>

    <div class="flex justify-between items-start mt-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $assignment->title }}</h1>
            <p class="text-sm text-gray-500 mt-1">Deadline: {{ $assignment->due_date->format('d M Y, H:i') }}</p>
        </div>
        <a href="{{ route('admin.assignments.edit', $assignment) }}"
           class="bg-amber-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-amber-600">
            Edit
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="font-semibold text-gray-700 mb-2">Deskripsi</h2>
        <p class="text-sm text-gray-600">{{ $assignment->description ?: 'Tidak ada deskripsi.' }}</p>

        @if($assignment->attachment_path)
            <p class="text-sm text-blue-600 mt-3">📎 {{ $assignment->attachment_original_name }}</p>
        @endif
    </div>

    <h2 class="font-semibold text-gray-700 mb-3">Daftar Submission ({{ $assignment->submissions->count() }})</h2>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 text-left">
                <tr>
                    <th class="px-4 py-3">Mahasiswa</th>
                    <th class="px-4 py-3">File</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Nilai</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($assignment->submissions as $submission)
                <tr>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $submission->user->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $submission->original_filename }}</td>
                    <td class="px-4 py-3">
                        @if($submission->status === 'pending')
                            <span class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-700">Pending</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Dinilai</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $submission->grade ?? '-' }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.submissions.show', $submission) }}" class="text-blue-600 hover:underline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada yang mengumpulkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
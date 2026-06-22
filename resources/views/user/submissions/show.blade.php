@extends('layouts.app')

@section('title', $assignment->title)

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('user.submissions.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali ke daftar tugas</a>

    <h1 class="text-2xl font-bold text-gray-800 mt-3">{{ $assignment->title }}</h1>
    <p class="text-sm text-gray-500 mt-1">Course: {{ $assignment->course->title }}</p>
    <p class="text-sm text-gray-500">Deadline: {{ $assignment->due_date->format('d M Y, H:i') }}</p>

    <div class="bg-white rounded-lg shadow-sm p-6 mt-4">
        <h2 class="font-semibold text-gray-700 mb-2">Deskripsi Tugas</h2>
        <p class="text-gray-600 text-sm">{{ $assignment->description ?: 'Tidak ada deskripsi.' }}</p>

        @if($assignment->attachment_path)
            <a href="{{ Storage::disk('private')->url($assignment->attachment_path) }}"
               class="inline-block mt-3 text-sm text-blue-600 hover:underline">
                📎 {{ $assignment->attachment_original_name }}
            </a>
        @endif
    </div>

    @if($submission)
        <div class="bg-white rounded-lg shadow-sm p-6 mt-4">
            <h2 class="font-semibold text-gray-700 mb-2">Submission Kamu</h2>
            <p class="text-sm text-gray-600">File: {{ $submission->original_filename }}</p>
            @if($submission->notes)
                <p class="text-sm text-gray-600 mt-1">Catatan: {{ $submission->notes }}</p>
            @endif

            @if($submission->status === 'graded')
                <div class="mt-3 bg-green-50 border border-green-200 rounded-lg p-3">
                    <p class="text-sm font-medium text-green-700">Nilai: {{ $submission->grade }}</p>
                    @if($submission->feedback)
                        <p class="text-sm text-green-600 mt-1">{{ $submission->feedback }}</p>
                    @endif
                </div>
            @else
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('user.submissions.edit', $submission) }}"
                       class="bg-amber-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-amber-600">
                        Edit Submission
                    </a>
                    <form action="{{ route('user.submissions.destroy', $submission) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus submission ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm p-6 mt-4">
            <h2 class="font-semibold text-gray-700 mb-4">Kumpulkan Tugas</h2>

            <form action="{{ route('user.submissions.store', $assignment) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">File Tugas</label>
                    <input type="file" name="file" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Format: PDF, DOCX, DOC, ZIP. Maksimal 10MB.</p>
                    @error('file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                    <textarea name="notes" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" maxlength="1000"></textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                    Kumpulkan Tugas
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
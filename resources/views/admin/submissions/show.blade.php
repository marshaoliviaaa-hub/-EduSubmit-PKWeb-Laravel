@extends('layouts.app')

@section('title', 'Detail Submission')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.submissions.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali ke daftar submission</a>

    <h1 class="text-2xl font-bold text-gray-800 mt-2 mb-6">Detail Submission</h1>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <p class="text-sm text-gray-500">Mahasiswa</p>
        <p class="font-medium text-gray-800 mb-3">{{ $submission->user->name }} ({{ $submission->user->email }})</p>

        <p class="text-sm text-gray-500">Tugas</p>
        <p class="font-medium text-gray-800 mb-3">{{ $submission->assignment->title }} - {{ $submission->assignment->course->title }}</p>

        <p class="text-sm text-gray-500">File</p>
        <p class="text-blue-600 mb-3">📎 {{ $submission->original_filename }}</p>

        @if($submission->notes)
            <p class="text-sm text-gray-500 mt-3">Catatan Mahasiswa</p>
            <p class="text-sm text-gray-700">{{ $submission->notes }}</p>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="font-semibold text-gray-700 mb-4">
            @if($submission->status === 'graded')
                Nilai Sudah Diberikan
            @else
                Beri Nilai
            @endif
        </h2>

        <form action="{{ route('admin.submissions.grade', $submission) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nilai (0-100)</label>
                <input type="number" name="grade" value="{{ old('grade', $submission->grade) }}"
                    min="0" max="100" step="0.01"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
                @error('grade')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Feedback (opsional)</label>
                <textarea name="feedback" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    maxlength="2000">{{ old('feedback', $submission->feedback) }}</textarea>
                @error('feedback')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                Simpan Nilai
            </button>
        </form>
    </div>
</div>
@endsection
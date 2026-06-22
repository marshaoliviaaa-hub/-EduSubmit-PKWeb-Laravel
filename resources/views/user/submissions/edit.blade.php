@extends('layouts.app')

@section('title', 'Edit Submission')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Submission</h1>

    <form action="{{ route('user.submissions.update', $submission) }}" method="POST"
          enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">File Saat Ini</label>
            <p class="text-sm text-gray-500">{{ $submission->original_filename }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti File (opsional)</label>
            <input type="file" name="file"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti file.</p>
            @error('file')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea name="notes" rows="3"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                maxlength="1000">{{ old('notes', $submission->notes) }}</textarea>
            @error('notes')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                Update
            </button>
            <a href="{{ route('user.submissions.show', $submission->assignment) }}"
               class="px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
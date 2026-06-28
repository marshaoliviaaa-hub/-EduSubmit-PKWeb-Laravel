@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.courses.show', $assignment->course) }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali ke {{ $assignment->course->title }}</a>

    <h1 class="text-2xl font-bold text-gray-800 mt-2 mb-6">Edit Tugas</h1>

    <form action="{{ route('admin.assignments.update', $assignment) }}" method="POST"
          enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas</label>
            <input type="text" name="title" value="{{ old('title', $assignment->title) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required minlength="3" maxlength="200">
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                maxlength="5000">{{ old('description', $assignment->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
            <input type="datetime-local" name="due_date"
                value="{{ old('due_date', $assignment->due_date->format('Y-m-d\TH:i')) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required>
            @error('due_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran Saat Ini</label>
            <p class="text-sm text-gray-500">{{ $assignment->attachment_original_name ?: 'Tidak ada lampiran' }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Lampiran (opsional)</label>
            <input type="file" name="attachment"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            @error('attachment')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                Update
            </button>
            <a href="{{ route('admin.courses.show', $assignment->course) }}" class="px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
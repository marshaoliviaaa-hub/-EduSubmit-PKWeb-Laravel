@extends('layouts.app')

@section('title', 'Daftar Tugas - ' . $course->title)

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <a href="{{ route('admin.courses.show', $course) }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali ke {{ $course->title }}</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">Daftar Tugas</h1>
    </div>
    <a href="{{ route('admin.courses.assignments.create', $course) }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Tambah Tugas
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 text-left">
            <tr>
                <th class="px-4 py-3">Judul</th>
                <th class="px-4 py-3">Deadline</th>
                <th class="px-4 py-3">Submission</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($assignments as $assignment)
            <tr>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $assignment->title }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $assignment->due_date->format('d M Y, H:i') }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $assignment->submissions()->count() }} pengumpulan</td>
                <td class="px-4 py-3 text-right space-x-2">
                    <a href="{{ route('admin.assignments.show', $assignment) }}" class="text-blue-600 hover:underline">Lihat</a>
                    <a href="{{ route('admin.assignments.edit', $assignment) }}" class="text-amber-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.assignments.destroy', $assignment) }}" method="POST" class="inline"
                          onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada tugas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $assignments->links() }}
</div>
@endsection
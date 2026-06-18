@extends('layouts.app')

@section('title', 'Daftar Course')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Daftar Course</h1>
    <a href="{{ route('admin.courses.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Tambah Course
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 text-left">
            <tr>
                <th class="px-4 py-3">Judul</th>
                <th class="px-4 py-3">Dibuat Oleh</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Dibuat</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($courses as $course)
            <tr>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $course->title }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $course->creator->name }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $course->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $course->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $course->created_at->format('d M Y') }}</td>
                <td class="px-4 py-3 text-right space-x-2">
                    <a href="{{ route('admin.courses.show', $course) }}" class="text-blue-600 hover:underline">Lihat</a>
                    <a href="{{ route('admin.courses.edit', $course) }}" class="text-amber-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline"
                          onsubmit="return confirm('Yakin ingin menghapus course ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada course.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $courses->links() }}
</div>
@endsection
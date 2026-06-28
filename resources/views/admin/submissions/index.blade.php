@extends('layouts.app')

@section('title', 'Semua Submission')

@section('content')
{{-- Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Semua Submission</h1>
    <p class="text-sm text-gray-500 mt-1">Daftar seluruh pengumpulan tugas mahasiswa</p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
        <p class="text-sm text-gray-500">Total Submission</p>
        <p class="text-3xl font-bold text-pink-600 mt-1">{{ $submissions->total() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
        <p class="text-sm text-gray-500">Menunggu Nilai</p>
        <p class="text-3xl font-bold text-amber-500 mt-1">
            {{ $submissions->getCollection()->where('status', 'pending')->count() }}
        </p>
    </div>
    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
        <p class="text-sm text-gray-500">Sudah Dinilai</p>
        <p class="text-3xl font-bold text-green-500 mt-1">
            {{ $submissions->getCollection()->where('status', 'graded')->count() }}
        </p>
    </div>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gradient-to-r from-pink-50 to-rose-50 text-gray-600 text-left">
            <tr>
                <th class="px-5 py-3.5 font-semibold">Mahasiswa</th>
                <th class="px-5 py-3.5 font-semibold">Tugas</th>
                <th class="px-5 py-3.5 font-semibold">Course</th>
                <th class="px-5 py-3.5 font-semibold">Status</th>
                <th class="px-5 py-3.5 font-semibold">Nilai</th>
                <th class="px-5 py-3.5 font-semibold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($submissions as $submission)
            <tr class="hover:bg-pink-50/50 transition">
                <td class="px-5 py-3.5">
                    <div class="font-medium text-gray-800">{{ $submission->user->name }}</div>
                    <div class="text-xs text-gray-400">{{ $submission->user->email }}</div>
                </td>
                <td class="px-5 py-3.5 text-gray-600">{{ $submission->assignment->title }}</td>
                <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $submission->assignment->course->title }}</td>
                <td class="px-5 py-3.5">
                    @if($submission->status === 'pending')
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">⏳ Pending</span>
                    @else
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">✅ Dinilai</span>
                    @endif
                </td>
                <td class="px-5 py-3.5">
                    @if($submission->grade)
                        <span class="font-semibold text-pink-600">{{ $submission->grade }}</span>
                    @else
                        <span class="text-gray-300">—</span>
                    @endif
                </td>
                <td class="px-5 py-3.5 text-right">
                    <a href="{{ route('admin.submissions.show', $submission) }}"
                       class="bg-pink-50 text-pink-600 hover:bg-pink-100 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                        Lihat Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-12 text-center">
                    <p class="text-4xl mb-3">📭</p>
                    <p class="text-gray-400">Belum ada submission.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $submissions->links() }}
</div>
@endsection
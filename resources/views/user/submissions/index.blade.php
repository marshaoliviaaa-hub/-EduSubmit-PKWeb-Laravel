@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Tugas</h1>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 text-left">
            <tr>
                <th class="px-4 py-3">Tugas</th>
                <th class="px-4 py-3">Course</th>
                <th class="px-4 py-3">Deadline</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($assignments as $assignment)
            @php
                $submission = $assignment->submissions->first();
            @endphp
            <tr>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $assignment->title }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $assignment->course->title }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $assignment->due_date->format('d M Y, H:i') }}</td>
                <td class="px-4 py-3">
                    @if(!$submission)
                        <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-500">Belum dikumpulkan</span>
                    @elseif($submission->status === 'pending')
                        <span class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-700">Menunggu nilai</span>
                    @else
                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Dinilai: {{ $submission->grade }}</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('user.submissions.show', $assignment) }}" class="text-blue-600 hover:underline">
                        Lihat Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada tugas yang tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $assignments->links() }}
</div>
@endsection
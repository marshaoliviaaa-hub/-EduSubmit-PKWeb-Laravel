@extends('layouts.app')

@section('title', 'Tambah Course')

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('admin.courses.index') }}" class="text-sm text-pink-500 hover:text-pink-700 flex items-center gap-1">
            ← Kembali ke Daftar Course
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Course Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Isi informasi course yang ingin ditambahkan</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-8">
        <form action="{{ route('admin.courses.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    📚 Judul Course
                </label>
                <input type="text" name="title" value="{{ old('title') }}"
                    placeholder="Contoh: Pemrograman Web"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-pink-300 focus:border-pink-400 focus:outline-none transition"
                    required minlength="3" maxlength="150">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    📝 Deskripsi
                    <span class="font-normal text-gray-400">(opsional)</span>
                </label>
                <textarea name="description" rows="4"
                    placeholder="Deskripsi singkat tentang course ini..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-pink-300 focus:border-pink-400 focus:outline-none transition resize-none"
                    maxlength="2000">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    🔘 Status
                </label>
                <select name="status"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-pink-300 focus:border-pink-400 focus:outline-none transition bg-white">
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>✅ Aktif</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>⏸️ Nonaktif</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="bg-gradient-to-r from-pink-500 to-rose-400 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:from-pink-600 hover:to-rose-500 transition shadow-sm">
                    Simpan Course
                </button>
                <a href="{{ route('admin.courses.index') }}"
                    class="px-6 py-2.5 rounded-xl text-sm text-gray-600 hover:bg-gray-100 transition border border-gray-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
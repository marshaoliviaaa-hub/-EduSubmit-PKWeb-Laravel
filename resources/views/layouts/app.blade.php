<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EduSubmit') }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 font-sans antialiased">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm border-b-2 border-pink-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo-pnc.png') }}" alt="Logo PNC" class="h-9 w-auto">
                    <div>
                        <span class="text-lg font-bold text-pink-600">EduSubmit</span>
                        <p class="text-xs text-gray-400 leading-none">Politeknik Negeri Cilacap</p>
                    </div>
                </a>

                {{-- Nav Links --}}
                <div class="flex items-center gap-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.courses.index') }}"
                               class="text-sm px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.courses*') ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-600 hover:bg-pink-50 hover:text-pink-600' }}">
                                📚 Courses
                            </a>
                            <a href="{{ route('admin.submissions.index') }}"
                               class="text-sm px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.submissions*') ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-600 hover:bg-pink-50 hover:text-pink-600' }}">
                                📋 Submissions
                            </a>
                        @else
                            <a href="{{ route('user.submissions.index') }}"
                               class="text-sm px-3 py-1.5 rounded-lg transition {{ request()->routeIs('user.*') ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-600 hover:bg-pink-50 hover:text-pink-600' }}">
                                📝 Tugas Saya
                            </a>
                        @endif

                        {{-- User Info + Logout --}}
                        <div class="flex items-center gap-2 ml-2 pl-2 border-l border-gray-200">
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                <span class="text-xs px-2 py-0.5 rounded-full
                                    {{ auth()->user()->isAdmin() ? 'bg-pink-100 text-pink-700' : 'bg-rose-100 text-rose-600' }}">
                                    {{ auth()->user()->isAdmin() ? 'Admin' : 'Mahasiswa' }}
                                </span>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="ml-2 text-xs bg-red-50 text-red-500 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    {{-- Flash Message --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-center text-xs text-gray-400 py-6 mt-10 border-t border-pink-100">
        &copy; {{ date('Y') }} <span class="text-pink-400 font-medium">EduSubmit</span> — Politeknik Negeri Cilacap. All rights reserved.
    </footer>

</body>
</html>
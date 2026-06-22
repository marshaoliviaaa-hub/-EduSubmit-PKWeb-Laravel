<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EduSubmit') }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                    EduSubmit
                </a>

                {{-- Nav Links --}}
                <div class="flex items-center gap-6">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.courses.index') }}"
                               class="text-sm text-gray-600 hover:text-blue-600 {{ request()->routeIs('admin.courses*') ? 'text-blue-600 font-semibold' : '' }}">
                                Courses
                            </a>
                            <a href="{{ route('admin.submissions.index') }}"
                               class="text-sm text-gray-600 hover:text-blue-600 {{ request()->routeIs('admin.submissions*') ? 'text-blue-600 font-semibold' : '' }}">
                                Submissions
                            </a>
                        @else
                            <a href="{{ route('user.submissions.index') }}"
                               class="text-sm text-gray-600 hover:text-blue-600 {{ request()->routeIs('user.*') ? 'text-blue-600 font-semibold' : '' }}">
                                Tugas Saya
                            </a>
                        @endif

                        {{-- User Info + Logout --}}
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                {{ auth()->user()->name }}
                                <span class="ml-1 px-2 py-0.5 text-xs rounded-full
                                    {{ auth()->user()->isAdmin() ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                    {{ auth()->user()->isAdmin() ? 'Admin' : 'User' }}
                                </span>
                            </span>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-sm text-red-500 hover:text-red-700">
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
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside text-sm">
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
    <footer class="text-center text-xs text-gray-400 py-6 mt-10 border-t border-gray-200">
        &copy; {{ date('Y') }} EduSubmit. All rights reserved.
    </footer>

</body>
</html>
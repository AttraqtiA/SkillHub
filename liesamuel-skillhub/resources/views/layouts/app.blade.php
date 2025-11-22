<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SkillHub – @yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Optional: small theme tweak --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        skillhub: {
                            50: '#ecfeff',
                            100: '#cffafe',
                            500: '#06b6d4',   // primary cyan
                            600: '#0891b2',
                            800: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex flex-col">

    {{-- Top Navbar --}}
    <header class="bg-skillhub-800 text-white">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="h-8 w-8 rounded-lg bg-skillhub-500 flex items-center justify-center text-sm font-bold">
                    SH
                </div>
                <div>
                    <div class="font-semibold text-lg tracking-tight">SkillHub</div>
                    <div class="text-xs text-skillhub-100/80">Course Management System</div>
                </div>
            </div>

            <nav class="flex gap-3 text-sm">
                <a href="{{ route('participants.index') }}"
                   class="px-3 py-1 rounded-md hover:bg-skillhub-600 {{ request()->routeIs('participants.*') ? 'bg-skillhub-600' : '' }}">
                    Participants
                </a>
                <a href="{{ route('course_classes.index') }}"
                   class="px-3 py-1 rounded-md hover:bg-skillhub-600 {{ request()->routeIs('course_classes.*') ? 'bg-skillhub-600' : '' }}">
                    Classes
                </a>
                <a href="{{ route('participant_classes.index') }}"
                   class="px-3 py-1 rounded-md hover:bg-skillhub-600 {{ request()->routeIs('participant_classes.*') ? 'bg-skillhub-600' : '' }}">
                    Enrollments
                </a>
            </nav>
        </div>
    </header>

    {{-- Main content --}}
    <main class="flex-1">
        <div class="max-w-6xl mx-auto px-4 py-6">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-4 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="max-w-6xl mx-auto px-4 py-3 text-xs text-slate-500 flex justify-between">
            <span>SkillHub &copy; {{ date('Y') }}</span>
            <span>Lie, Samuel Miracle Kristanto - 0706012210011</span>
        </div>
    </footer>

</body>
</html>

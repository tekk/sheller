<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sheller') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@supabase/supabase-js@2"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        background: '#0d1117',
                        surface: '#161b22',
                        primary: '#2dd4bf', // Teal-400
                        secondary: '#a78bfa', // Purple
                        accent: '#f9e2af', // Yellow
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #0d1117;
            color: #c9d1d9;
            font-family: 'JetBrains Mono', monospace;
        }

        .nerd-box {
            border: 1px solid #30363d;
            background: #161b22;
            box-shadow: 4px 4px 0px #2dd4bf;
        }

        .glass-panel {
            background: rgba(22, 27, 34, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid #30363d;
        }

        .btn-nerd {
            background: #2dd4bf;
            color: #0d1117;
            font-weight: bold;
            border: 2px solid #2dd4bf;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-nerd:hover {
            background: transparent;
            color: #2dd4bf;
            box-shadow: 2px 2px 0px #a78bfa;
            transform: translate(-2px, -2px);
        }

        .btn-secondary {
            background: transparent;
            color: #a78bfa;
            border: 2px solid #a78bfa;
            font-weight: bold;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #a78bfa;
            color: #0d1117;
            box-shadow: 2px 2px 0px #2dd4bf;
            transform: translate(-2px, -2px);
        }

        input,
        textarea,
        select {
            background: #0d1117;
            border: 1px solid #30363d;
            color: #c9d1d9;
            padding: 0.5rem;
            width: 100%;
            outline: none;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #2dd4bf;
            box-shadow: 0 0 0 2px rgba(45, 212, 191, 0.2);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0d1117;
        }

        ::-webkit-scrollbar-thumb {
            background: #30363d;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2dd4bf;
        }
    </style>
</head>

<body class="antialiased min-h-screen flex flex-col">
    <nav class="border-b border-gray-800 p-4 flex justify-between items-center bg-[#161b22]">
        <a href="{{ route('home') }}"
            class="text-2xl font-bold text-primary flex items-center gap-2 hover:text-accent transition-colors">
            <img src="{{ asset('logo.png') }}" class="h-8 w-8 rounded bg-gray-900 border border-secondary"
                alt="Sheller Logo">
            Sheller
        </a>
        <div class="flex gap-4 items-center">
            @auth
                <a href="{{ route('dashboard.index') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <span class="text-gray-600">|</span>
                <div class="flex items-center gap-2">
                    @if(Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" class="w-8 h-8 rounded-full border border-gray-600">
                    @endif
                    <span class="text-secondary hidden md:inline">{{ Auth::user()->name }}</span>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-nerd px-4 py-1 text-sm">Login</a>
            @endauth
        </div>
    </nav>

    <main class="flex-grow container mx-auto p-4 md:p-8">
        {{ $slot }}
    </main>

    <footer class="border-t border-gray-800 p-6 text-center text-gray-600 text-sm mt-auto">
        <p class="mb-2">Sheller v1.0.0 | <span class="text-primary">root@sheller:~$</span> exit 0</p>
        <p class="text-xs text-gray-700">Powered by PHP & Laravel</p>
    </footer>

    @stack('scripts')
</body>

</html>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sheller Installation</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        primary: '#2dd4bf',
                        secondary: '#a78bfa',
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

        .input {
            background: #0d1117;
            border: 1px solid #30363d;
            color: #c9d1d9;
            padding: 0.5rem;
            width: 100%;
        }

        .btn-nerd {
            background: #2dd4bf;
            color: #0d1117;
            font-weight: bold;
            padding: 0.5rem 1rem;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center p-4">
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-primary">Sheller Installer</h1>
        <p class="text-gray-500">System Configuration Wizard</p>
    </div>

    <div class="nerd-box p-8 w-full max-w-lg">
        {{ $slot }}
    </div>
</body>

</html>
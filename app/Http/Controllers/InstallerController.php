<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstallerController extends Controller
{
    public function welcome()
    {
        return view('install.welcome', [
            'phpVersion' => PHP_VERSION,
            'extensions' => [
                'pdo' => extension_loaded('pdo'),
                'curl' => extension_loaded('curl'),
                'fileinfo' => extension_loaded('fileinfo'),
            ],
            'writable' => is_writable(base_path('.env')) || is_writable(base_path()),
        ]);
    }

    public function databaseForm()
    {
        return view('install.database');
    }

    public function supabaseForm()
    {
        return view('install.supabase');
    }

    public function process(Request $request)
    {
        // This is a simplified "all-in-one" step or multi-step handler
        // For simplicity, let's just save ENV vars that are posted

        $data = $request->except('_token', 'next');

        // Read .env or .env.example
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            if (file_exists(base_path('.env.example'))) {
                copy(base_path('.env.example'), $envPath);
            } else {
                touch($envPath);
            }
        }

        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $key = strtoupper($key);
            // Quote value if needed (contains spaces)
            if (str_contains($value, ' ') && !str_starts_with($value, '"')) {
                $value = '"' . $value . '"';
            }

            // Regex to replace or append
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            } else {
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envContent);

        if ($request->next === 'finish') {
            return redirect()->route('install.finish');
        }

        return redirect()->route($request->next);
    }

    public function finish()
    {
        try {
            // Check if key is set
            if (!config('app.key')) {
                \Illuminate\Support\Facades\Artisan::call('key:generate', ['--force' => true]);
            }

            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            \Illuminate\Support\Facades\Artisan::call('storage:link');

            // Create lock file
            $installedPath = storage_path('app/installed');
            if (file_put_contents($installedPath, 'INSTALLED ON ' . date('Y-m-d H:i:s')) === false) {
                throw new \Exception("Could not create lock file at {$installedPath}. Please check permissions.");
            }

            return redirect()->route('home')->with('success', 'Installation Complete!');
        } catch (\Exception $e) {
            return response()->view('install.welcome', [
                'error' => $e->getMessage(),
                'phpVersion' => PHP_VERSION,
                'extensions' => [],
                'writable' => true
            ]); // Fallback to welcome with error
        }
    }
}

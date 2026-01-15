<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetupController extends Controller
{
    public function __invoke(Request $request)
    {
        // Simple security check using APP_KEY (or a substring of it) if not in production to match
        // Or require a special SETUP_KEY in .env
        $authKey = config('app.key');
        if (!$request->has('key') || $request->key !== $authKey) {
            // Allow if local environment
            if (app()->environment('local')) {
                // pass
            } else {
                return response('Unauthorized. Please provide ?key=YOUR_APP_KEY', 403);
            }
        }

        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            $migrateOutput = \Illuminate\Support\Facades\Artisan::output();

            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            $optimizeOutput = \Illuminate\Support\Facades\Artisan::output();

            // Try storage link (might fail on shared hosting if symlinks disabled)
            try {
                \Illuminate\Support\Facades\Artisan::call('storage:link');
                $storageOutput = \Illuminate\Support\Facades\Artisan::output();
            } catch (\Exception $e) {
                $storageOutput = "Storage link failed: " . $e->getMessage();
            }

            return "<pre>Migration:\n$migrateOutput\n\nOptimize:\n$optimizeOutput\n\nStorage:\n$storageOutput</pre>";
        } catch (\Exception $e) {
            return response("Setup Error: " . $e->getMessage(), 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExecutionController extends Controller
{
    public function invoke(Request $request, string $slug)
    {
        $alias = \App\Models\Alias::where('slug', $slug)->firstOrFail();

        // Check visibility (Private aliases only accessible by owner)
        // Note: For curl access, authentication is tricky.
        // We will assume 'unlisted' and 'public' are accessible. 
        // 'Private' -> 404 (to hide existence) or 403.
        if ($alias->visibility === 'private') {
            // If we implement API tokens, check here. 
            // For now, just block unless it's a browser session (unlikely for curl).
            if ($request->user()?->id !== $alias->user_id) {
                abort(404);
            }
        }

        $command = $alias->resolveCommand($request->all());

        return response($command, 200, ['Content-Type' => 'text/plain']);
    }
}

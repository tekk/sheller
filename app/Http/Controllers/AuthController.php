<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function callback()
    {
        return view('auth.callback');
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'access_token' => 'required',
        ]);

        try {
            $token = $request->access_token;
            $key = env('SUPABASE_JWT_SECRET');
            // Fallback or error if missing
            if (!$key) {
                return response()->json(['error' => 'Server misconfigured (JWT Secret)'], 500);
            }

            $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($key, 'HS256'));

            // $decoded->sub is the supabase user ID
            // $decoded->email is the email

            $user = \App\Models\User::firstOrCreate(
                ['supabase_id' => $decoded->sub],
                [
                    'name' => $decoded->user_metadata->full_name ?? explode('@', $decoded->email)[0],
                    'email' => $decoded->email,
                    'password' => \Illuminate\Support\Str::random(32), // Dummy password
                    'avatar_url' => $decoded->user_metadata->avatar_url ?? null,
                ]
            );

            \Illuminate\Support\Facades\Auth::login($user);

            return response()->json(['redirect' => route('dashboard.index')]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid Token: ' . $e->getMessage()], 401);
        }
    }
}

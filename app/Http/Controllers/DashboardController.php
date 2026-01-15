<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $aliases = auth()->user()->aliases()->latest()->get();
        return view('dashboard.index', compact('aliases'));
    }

    public function create()
    {
        return view('dashboard.create', ['alias' => new \App\Models\Alias()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|alpha_dash|unique:aliases,slug',
            'command' => 'required|string',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,unlisted,private',
            'parameters' => 'nullable|json',
        ]);

        if (!empty($validated['parameters'])) {
            $validated['parameters'] = json_decode($validated['parameters'], true);
        } else {
            $validated['parameters'] = [];
        }

        auth()->user()->aliases()->create($validated);

        return redirect()->route('dashboard.index')->with('success', 'Alias created!');
    }

    public function edit(string $id)
    {
        $alias = auth()->user()->aliases()->findOrFail($id);
        return view('dashboard.create', ['alias' => $alias]);
    }

    public function update(Request $request, string $id)
    {
        $alias = auth()->user()->aliases()->findOrFail($id);

        $validated = $request->validate([
            'slug' => 'required|alpha_dash|unique:aliases,slug,' . $alias->id,
            'command' => 'required|string',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,unlisted,private',
            'parameters' => 'nullable|json',
        ]);

        if (!empty($validated['parameters'])) {
            $validated['parameters'] = json_decode($validated['parameters'], true);
        } else {
            $validated['parameters'] = [];
        }

        $alias->update($validated);

        return redirect()->route('dashboard.index')->with('success', 'Alias updated!');
    }

    public function destroy(string $id)
    {
        $alias = auth()->user()->aliases()->findOrFail($id);
        $alias->delete();
        return back()->with('success', 'Alias deleted.');
    }
}

<x-layout>
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-primary">My Aliases</h2>
        <a href="{{ route('dashboard.create') }}" class="btn-nerd px-4 py-2">
            + New Alias
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-900 border border-green-500 text-green-200 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto nerd-box p-4">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-700 text-secondary">
                    <th class="p-3">Slug</th>
                    <th class="p-3">Command</th>
                    <th class="p-3">Visibility</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aliases as $alias)
                    <tr class="border-b border-gray-800 hover:bg-[#0d1117] transition-colors group">
                        <td class="p-3 font-bold text-accent">/{{ $alias->slug }}</td>
                        <td class="p-3 font-mono text-xs text-gray-400 max-w-xs truncate" title="{{ $alias->command }}">
                            {{ $alias->command }}</td>
                        <td class="p-3 text-sm">
                            <span class="px-2 py-1 rounded text-xs border border-gray-700
                                    {{ $alias->visibility === 'public' ? 'bg-green-900 text-green-300' : '' }}
                                    {{ $alias->visibility === 'unlisted' ? 'bg-yellow-900 text-yellow-300' : '' }}
                                    {{ $alias->visibility === 'private' ? 'bg-red-900 text-red-300' : '' }}
                                ">
                                {{ ucfirst($alias->visibility) }}
                            </span>
                        </td>
                        <td class="p-3 flex gap-2 justify-end">
                            <button
                                onclick="navigator.clipboard.writeText('curl -sL {{ route('exec', $alias->slug) }} | bash');"
                                class="text-gray-400 hover:text-white p-1" title="Copy Curl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </button>
                            <a href="{{ route('dashboard.edit', $alias->id) }}"
                                class="text-blue-400 hover:text-blue-300 p-1" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('dashboard.destroy', $alias->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 p-1" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">
                            No aliases found. Create one to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
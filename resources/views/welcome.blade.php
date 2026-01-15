<x-layout>
    <div class="text-center mb-16 mt-8">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 text-primary tracking-tight">
            Sheller<span class="text-secondary opacity-50">_</span>
        </h1>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">
            The modern way to manage and share your shell aliases.
            <span class="text-accent">Write once, curl everywhere.</span>
        </p>

        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('dashboard.index') }}" class="btn-nerd px-8 py-3 rounded text-lg">
                Create Alias
            </a>
            <a href="https://github.com/tekk/sheller" target="_blank" class="btn-secondary px-8 py-3 rounded text-lg">
                Source Code
            </a>
        </div>
    </div>

    <div class="mb-8 flex justify-between items-end border-b border-gray-800 pb-4">
        <h2 class="text-2xl font-bold text-gray-200">Public Aliases</h2>
        <div class="text-sm text-gray-500">
            {{ count($aliases) }} commands available
        </div>
    </div>

    @if(count($aliases) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($aliases as $alias)
                <div class="nerd-box p-6 flex flex-col h-full relative group transition-all hover:border-primary">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-2xl font-bold text-accent">
                            <span class="text-gray-600">/</span>{{ $alias->slug }}
                        </h3>
                        <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">
                            {{ $alias->updated_at->diffForHumans() }}
                        </span>
                    </div>

                    <p class="text-gray-400 text-sm mb-6 flex-grow leading-relaxed">
                        {{ $alias->description ?? 'No description provided.' }}
                    </p>

                    <div class="bg-[#0d1117] p-4 rounded font-mono text-xs text-green-400 mb-4 overflow-x-auto border border-gray-800 shadow-inner group-hover:border-gray-700 transition-colors relative">
                        <div class="absolute top-2 right-2 flex gap-1">
                             <button onclick="setOS(this, 'nix')" class="text-[10px] px-1.5 rounded bg-gray-700 text-white hover:bg-gray-600 transition-colors os-btn active-os" data-os="nix">NIX</button>
                             <button onclick="setOS(this, 'win')" class="text-[10px] px-1.5 rounded bg-gray-800 text-gray-400 hover:bg-gray-700 transition-colors os-btn" data-os="win">WIN</button>
                        </div>
                        <div class="flex gap-2 pt-2">
                            <span class="select-none text-gray-600">$</span>
                            <span class="whitespace-nowrap cmd-nix">curl -sL {{ route('exec', $alias->slug) }} | bash</span>
                            <span class="whitespace-nowrap cmd-win hidden">irm {{ route('exec', $alias->slug) }} | iex</span>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-auto">
                        <button
                            onclick="copyCmd(this)"
                            onmouseout="setTimeout(() => this.innerText = 'Copy Command', 2000)"
                            class="btn-nerd w-full py-2 text-center text-sm">
                            Copy Command
                        </button>
                    </div>

                    @if($alias->parameters)
                        <div class="mt-2 text-[10px] text-gray-500 font-mono text-center">
                            <span class="text-secondary">With vars:</span> curl .../{{ $alias->slug }}?<span
                                class="text-accent">{{ strtolower(array_key_first($alias->parameters)) }}=value</span>
                        </div>
                    @endif

                    @if($alias->parameters)
                        <div class="mt-3 pt-3 border-t border-gray-800">
                            <p class="text-xs text-gray-500 mb-1">Parameters:</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_keys($alias->parameters) as $param)
                                    <span class="text-[10px] bg-gray-800 text-secondary px-1.5 py-0.5 rounded border border-gray-700">
                                        {{ $param }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 border border-dashed border-gray-800 rounded-lg">
            <p class="text-gray-500 mb-4">No public aliases found.</p>
            <a href="{{ route('dashboard.index') }}" class="text-primary hover:underline">Create the first one!</a>
        </div>
    @endif
    @push('scripts')
    <script>
        function setOS(btn, os) {
            const card = btn.closest('.nerd-box');
            // Toggle buttons
            card.querySelectorAll('.os-btn').forEach(b => {
                b.classList.remove('bg-gray-700', 'text-white');
                b.classList.add('bg-gray-800', 'text-gray-400');
            });
            btn.classList.remove('bg-gray-800', 'text-gray-400');
            btn.classList.add('bg-gray-700', 'text-white');
            
            // Toggle content
            card.querySelector('.cmd-nix').classList.toggle('hidden', os !== 'nix');
            card.querySelector('.cmd-win').classList.toggle('hidden', os !== 'win');
        }

        function copyCmd(btn) {
            const card = btn.closest('.nerd-box');
            const os = card.querySelector('.os-btn.bg-gray-700').dataset.os; // Active OS
            const text = card.querySelector('.cmd-' + os).innerText;
            navigator.clipboard.writeText(text);
            btn.innerText = 'Copied!';
        }
    </script>
    @endpush
</x-layout>
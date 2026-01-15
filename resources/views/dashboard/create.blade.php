<x-layout>
    <div class="max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold text-primary mb-8">{{ $alias->exists ? 'Edit Alias' : 'Create Alias' }}</h2>

        <form action="{{ $alias->exists ? route('dashboard.update', $alias->id) : route('dashboard.store') }}"
            method="POST" class="nerd-box p-6 space-y-6">
            @csrf
            @if($alias->exists) @method('PUT') @endif

            <div>
                <label class="block text-secondary mb-2 font-bold">Slug</label>
                <div class="flex">
                    <span
                        class="bg-gray-800 text-gray-400 p-2 border border-r-0 border-gray-700 rounded-l flex items-center">/</span>
                    <input type="text" name="slug" value="{{ old('slug', $alias->slug) }}" class="rounded-l-none"
                        placeholder="oniux" required>
                </div>
                <!-- Helper text for usage -->
                <p class="text-xs text-gray-500 mt-1">Access via: curl {{ url('/') }}/[slug] | bash</p>
                @error('slug') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-secondary mb-2 font-bold">Command Template</label>
                <!-- Hidden Input to store value -->
                <input type="hidden" name="command" id="param-command" value="{{ old('command', $alias->command) }}">

                <!-- Editor Container -->
                <div id="monaco-editor" class="h-64 border border-gray-700 rounded overflow-hidden"></div>

                <p class="text-xs text-gray-500 mt-1">Use {$VAR} for variables. Case insensitive replacements. (Monaco
                    Editor Active)</p>
                @error('command') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            @push('scripts')
                <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>
                <script>
                    require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' } });
                    require(['vs/editor/editor.main'], function () {
                        var editor = monaco.editor.create(document.getElementById('monaco-editor'), {
                            value: document.getElementById('param-command').value,
                            language: 'shell',
                            theme: 'vs-dark',
                            minimap: { enabled: false },
                            scrollBeyondLastLine: false,
                            automaticLayout: true,
                            fontFamily: "'JetBrains Mono', monospace",
                            fontSize: 14
                        });

                        // Sync content on change
                        editor.onDidChangeModelContent(function () {
                            document.getElementById('param-command').value = editor.getValue();
                        });

                        // Also sync on form submit just in case
                        document.querySelector('form').addEventListener('submit', function () {
                            document.getElementById('param-command').value = editor.getValue();
                        });
                    });
                </script>
            @endpush

            <div>
                <label class="block text-secondary mb-2 font-bold">Default Parameters (JSON)</label>
                <textarea name="parameters" rows="3" class="font-mono text-sm"
                    placeholder='{"TAG": "latest"}'>{{ old('parameters', $alias->parameters ? json_encode($alias->parameters, JSON_PRETTY_PRINT) : '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Define default values for your variables. Must be valid JSON.</p>
                @error('parameters') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-secondary mb-2 font-bold">Visibility</label>
                    <div class="relative">
                        <select name="visibility" class="appearance-none">
                            <option value="public" {{ old('visibility', $alias->visibility) == 'public' ? 'selected' : '' }}>Public (Listed)</option>
                            <option value="unlisted" {{ old('visibility', $alias->visibility) == 'unlisted' ? 'selected' : '' }}>Unlisted (Link Only)</option>
                            <option value="private" {{ old('visibility', $alias->visibility) == 'private' ? 'selected' : '' }}>Private (Auth Only)</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-secondary mb-2 font-bold">Description</label>
                    <input type="text" name="description" value="{{ old('description', $alias->description) }}"
                        placeholder="Short description of what this does">
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-4 border-t border-gray-800">
                <a href="{{ route('dashboard.index') }}" class="btn-secondary px-6 py-2">Cancel</a>
                <button type="submit" class="btn-nerd px-6 py-2">Save Alias</button>
            </div>
        </form>
    </div>
</x-layout>
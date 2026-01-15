<x-install.layout>
    <div class="space-y-4">
        <div class="border-b border-gray-700 pb-4 mb-4">
            <h2 class="text-xl font-bold text-secondary">System Check</h2>
        </div>

        <div class="flex justify-between items-center">
            <span>PHP Version (>= 8.2)</span>
            <span class="{{ $phpVersion >= '8.2' ? 'text-green-400' : 'text-red-400' }}">
                {{ $phpVersion }} {{ $phpVersion >= '8.2' ? '✔' : '✘' }}
            </span>
        </div>

        @foreach($extensions as $ext => $enabled)
            <div class="flex justify-between items-center">
                <span>Extension: {{ $ext }}</span>
                <span class="{{ $enabled ? 'text-green-400' : 'text-red-400' }}">
                    {{ $enabled ? 'Installed' : 'Missing' }} {{ $enabled ? '✔' : '✘' }}
                </span>
            </div>
        @endforeach

        <div class="flex justify-between items-center">
            <span>Write Permissions (.env)</span>
            <span class="{{ $writable ? 'text-green-400' : 'text-red-400' }}">
                {{ $writable ? 'Writable' : 'Read-Only' }} {{ $writable ? '✔' : '✘' }}
            </span>
        </div>

        @if(!$writable)
            <div class="bg-red-900/30 border border-red-500 p-3 rounded text-sm text-red-200 mt-4">
                Warning: The installer cannot write to the <code>.env</code> file. You will need to create it manually.
            </div>
        @endif

        <div class="pt-6 flex justify-end">
            <a href="{{ route('install.database') }}" class="btn-nerd">Next: Database ></a>
        </div>
    </div>
</x-install.layout>
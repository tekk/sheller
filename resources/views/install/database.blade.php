<x-install.layout>
    <form action="{{ route('install.process') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="next" value="install.supabase">

        <div class="border-b border-gray-700 pb-4 mb-4">
            <h2 class="text-xl font-bold text-secondary">Database Configuration</h2>
        </div>

        <div>
            <label class="block mb-1 text-sm">Database Type</label>
            <select name="DB_CONNECTION" class="input"
                onchange="this.value === 'sqlite' ? document.getElementById('mysql-fields').classList.add('hidden') : document.getElementById('mysql-fields').classList.remove('hidden')">
                <option value="mysql">MySQL / MariaDB</option>
                <option value="sqlite">SQLite</option>
            </select>
        </div>

        <div id="mysql-fields" class="space-y-4">
            <div class="grid grid-cols-3 gap-2">
                <div class="col-span-2">
                    <label class="block mb-1 text-sm">Host</label>
                    <input type="text" name="DB_HOST" value="127.0.0.1" class="input">
                </div>
                <div>
                    <label class="block mb-1 text-sm">Port</label>
                    <input type="text" name="DB_PORT" value="3306" class="input">
                </div>
            </div>

            <div>
                <label class="block mb-1 text-sm">Database Name</label>
                <input type="text" name="DB_DATABASE" value="sheller" class="input">
            </div>

            <div>
                <label class="block mb-1 text-sm">Username</label>
                <input type="text" name="DB_USERNAME" value="root" class="input">
            </div>

            <div>
                <label class="block mb-1 text-sm">Password</label>
                <input type="password" name="DB_PASSWORD" class="input">
            </div>
        </div>

        <div class="pt-6 flex justify-end">
            <button type="submit" class="btn-nerd">Next: Supabase ></button>
        </div>
    </form>
</x-install.layout>
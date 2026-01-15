<x-install.layout>
    <form action="{{ route('install.process') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="next" value="finish">

        <div class="border-b border-gray-700 pb-4 mb-4">
            <h2 class="text-xl font-bold text-secondary">Supabase Configuration</h2>
        </div>

        <div>
            <label class="block mb-1 text-sm">App URL</label>
            <input type="text" name="APP_URL" value="{{ url('/') }}" class="input" required>
        </div>

        <div>
            <label class="block mb-1 text-sm">Supabase Project URL</label>
            <input type="text" name="SUPABASE_URL" placeholder="https://xyz.supabase.co" class="input" required>
        </div>

        <div>
            <label class="block mb-1 text-sm">Supabase Anon Key</label>
            <input type="password" name="SUPABASE_KEY" placeholder="ey..." class="input" required>
        </div>

        <div>
            <label class="block mb-1 text-sm">JWT Secret</label>
            <input type="password" name="SUPABASE_JWT_SECRET" placeholder="Get this from API Settings" class="input"
                required>
        </div>

        <div class="bg-blue-900/30 border border-blue-500 p-3 rounded text-sm text-blue-200 mt-4">
            Recall to enable <strong>GitHub</strong> or <strong>Email</strong> Provider in your Supabase Auth settings.
        </div>

        <div class="pt-6 flex justify-end">
            <button type="submit" class="btn-nerd">Complete Installation ></button>
        </div>
    </form>
</x-install.layout>
<x-layout>
    <div class="flex flex-col items-center justify-center min-h-[50vh]">
        <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-primary mb-4"></div>
        <h2 class="text-xl text-gray-300">Authenticating...</h2>
        <p id="status" class="text-sm text-gray-500 mt-2">Verifying token...</p>
    </div>

    @push('scripts')
        <script>
            const supabaseUrl = '{{ env("SUPABASE_URL") }}';
            const supabaseKey = '{{ env("SUPABASE_KEY") }}';
            const supabase = window.supabase.createClient(supabaseUrl, supabaseKey);

            async function handleCallback() {
                // Get session from Supabase (handles hash parsing)
                const { data: { session }, error } = await supabase.auth.getSession();

                if (error || !session) {
                    // Try to check if we have a hash manually? 
                    // Supabase client should handle it if initialized.
                    // Sometimes handling redirect takes a moment.
                    // We can also check URL params for 'error'.
                    console.error('No session', error);
                    if (window.location.hash.includes('access_token')) {
                        // Wait a bit, maybe supabase is slow to parse?
                        // Or force manual token extraction if needed.
                    }

                    // If totally failed
                    setTimeout(() => {
                        if (document.getElementById('status').innerText.includes('Verifying')) {
                            document.getElementById('status').innerText = 'Login Failed: ' + (error?.message || 'No Session found. Check console.');
                        }
                    }, 3000);
                    return;
                }

                // Send access token to backend
                const response = await fetch('{{ url("/auth/confirm") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ access_token: session.access_token })
                });

                const result = await response.json();

                if (result.redirect) {
                    window.location.href = result.redirect;
                } else {
                    document.getElementById('status').innerText = 'Backend Error: ' + (result.error || 'Unknown');
                    console.error(result);
                }
            }

            // Supabase onAuthStateChange might be safer
            supabase.auth.onAuthStateChange((event, session) => {
                if (event === 'SIGNED_IN' || event === 'INITIAL_SESSION') {
                    handleCallback();
                }
            });

            // Also call valid?
            handleCallback();
        </script>
    @endpush
</x-layout>
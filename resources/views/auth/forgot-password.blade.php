<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800 text-center">Forgot Your Password?</h2>
            <p class="text-sm text-gray-500 text-center">
                Enter your email address and we will send you a password reset link.
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-green-600 font-medium" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="block text-gray-700 font-medium mb-1" />
                    <x-text-input id="email" 
                        class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
<script>
    // Slide-up animation
    document.addEventListener('DOMContentLoaded', () => {
        const card = document.querySelector('.max-w-md');
        setTimeout(() => {
            card.classList.remove('opacity-0', 'translate-y-8');
        }, 100);
    });

    // Toggle password visibility
    function togglePassword(fieldId, button) {
        const field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
            button.textContent = '🙈';
        } else {
            field.type = "password";
            button.textContent = '👁';
        }
    }
</script>
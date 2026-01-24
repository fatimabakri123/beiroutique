<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-10">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 space-y-6 transform transition duration-700 ease-out opacity-0 translate-y-8" id="resetCard">
            <h2 class="text-2xl font-semibold text-gray-800 text-center">Reset Your Password</h2>
            <p class="text-sm text-gray-500 text-center">
                Enter your email and new password to reset your account.
            </p>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="block text-gray-700 font-medium mb-1" />
                    <x-text-input id="email" 
                        class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Password -->
                <div class="relative">
                    <x-input-label for="password" :value="__('Password')" class="block text-gray-700 font-medium mb-1" />
                    <x-text-input id="password" 
                        class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 pr-10"
                        type="password" name="password" required autocomplete="new-password" />
                    <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-500" onclick="togglePassword('password', this)">
                        👁
                    </button>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
                </div>

                <!-- Confirm Password -->
                <div class="relative">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-gray-700 font-medium mb-1" />
                    <x-text-input id="password_confirmation" 
                        class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 pr-10"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-500" onclick="togglePassword('password_confirmation', this)">
                        👁
                    </button>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-600" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Slide-up animation
        document.addEventListener('DOMContentLoaded', () => {
            const card = document.getElementById('resetCard');
            setTimeout(() => {
                card.classList.remove('opacity-0', 'translate-y-8');
            }, 100);
        });

        // Toggle password visibility
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                btn.textContent = "🙈";
            } else {
                input.type = "password";
                btn.textContent = "👁";
            }
        }
    </script>
</x-guest-layout>

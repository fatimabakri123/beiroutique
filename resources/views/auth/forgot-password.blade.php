<x-guest-layout>
    <div class="forgot-password-page">
        <div class="card max-w-md">
            <h2>Forgot Your Password?</h2>
            <p>Enter your email address and we will send you a password reset link.</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-green-600 font-medium" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="block mb-1" />
                    <x-text-input id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-600" />
                </div>

                <!-- Submit Button -->
                <div>
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* ===== BODY & PAGE ===== */
        .forgot-password-page {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            padding: 1rem;
        }

        /* ===== CARD ===== */
        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-in-out;
        }

        .card.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== HEADINGS ===== */
        h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e1e2f;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        p {
            font-size: 0.95rem;
            color: #555770;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        /* ===== INPUT ===== */
        input[type="email"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s ease;
        }

        input[type="email"]:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.2);
        }

        /* ===== BUTTON ===== */
        button {
            width: 100%;
            padding: 0.75rem;
            background: #6c63ff;
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: #574fd6;
            transform: translateY(-2px);
        }

        /* ===== ERROR & STATUS ===== */
        .text-green-600 {
            color: #28a745;
            text-align: center;
            font-weight: 500;
        }

        .text-red-600 {
            color: #dc3545;
            font-size: 0.85rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .card {
                padding: 1.5rem;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const card = document.querySelector('.card');
            setTimeout(() => {
                card.classList.add('show');
            }, 100);
        });
    </script>
</x-guest-layout>

<section>
    <style>
        .modern-form-group {
            margin-bottom: 1.5rem;
        }

        .modern-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .modern-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .modern-input:focus {
            outline: none;
            border-color: #4285F4;
            box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.1);
            background: rgba(255, 255, 255, 0.95);
        }

        .modern-input:hover {
            border-color: rgba(66, 133, 244, 0.3);
        }

        .modern-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #4285F4 0%, #1a73e8 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(66, 133, 244, 0.4);
        }

        .modern-btn:active {
            transform: translateY(0);
        }

        .modern-btn-secondary {
            background: transparent;
            color: #4285F4;
            border: 2px solid #4285F4;
            box-shadow: none;
        }

        .modern-btn-secondary:hover {
            background: #4285F4;
            color: white;
        }

        .error-message {
            color: #EA4335;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .success-message {
            color: #34A853;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .info-message {
            background: rgba(251, 188, 4, 0.1);
            border: 1px solid rgba(251, 188, 4, 0.3);
            color: #856404;
            padding: 1rem;
            border-radius: 12px;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .verification-btn {
            color: #4285F4;
            text-decoration: underline;
            background: none;
            border: none;
            cursor: pointer;
            font-size: inherit;
            margin-left: 0.25rem;
        }

        .verification-btn:hover {
            color: #1a73e8;
        }

        .button-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .button-group {
                flex-direction: column;
                align-items: stretch;
            }

            .modern-btn {
                text-align: center;
                justify-content: center;
            }
        }
    </style>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('patch')

        <div class="modern-form-group">
            <label for="name" class="modern-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                {{ __('Full Name') }}
            </label>
            <input
                id="name"
                name="name"
                type="text"
                class="modern-input"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Enter your full name"
            />
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="modern-form-group">
            <label for="email" class="modern-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                </svg>
                {{ __('Email Address') }}
            </label>
            <input
                id="email"
                name="email"
                type="email"
                class="modern-input"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                placeholder="Enter your email address"
            />
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="info-message">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <strong>Email Verification Required</strong>
                    </div>
                    <p>Your email address is unverified.</p>
                    <button form="send-verification" class="verification-btn">
                        Click here to re-send the verification email.
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="success-message" style="margin-top: 0.5rem;">
                            ✓ A new verification link has been sent to your email address.
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="button-group">
            <button type="submit" class="modern-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="success-message"
                    style="display: flex; align-items: center; gap: 0.5rem;"
                >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Profile updated successfully!
                </div>
            @endif
        </div>
    </form>
</section>

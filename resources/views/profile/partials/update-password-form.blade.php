<section>
    <style>
        .password-form-group {
            margin-bottom: 1.5rem;
        }

        .password-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .password-input-container {
            position: relative;
        }

        .password-input {
            width: 100%;
            padding: 0.75rem 3rem 0.75rem 1rem;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .password-input:focus {
            outline: none;
            border-color: #34A853;
            box-shadow: 0 0 0 3px rgba(52, 168, 83, 0.1);
            background: rgba(255, 255, 255, 0.95);
        }

        .password-input:hover {
            border-color: rgba(52, 168, 83, 0.3);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #5f6368;
            padding: 0.25rem;
            border-radius: 4px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #34A853;
        }

        .password-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #34A853 0%, #2d7a3f 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(52, 168, 83, 0.3);
        }

        .password-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(52, 168, 83, 0.4);
        }

        .password-btn:active {
            transform: translateY(0);
        }

        .password-error {
            color: #EA4335;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .password-success {
            color: #34A853;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .password-strength {
            margin-top: 0.5rem;
            display: none;
        }

        .strength-meter {
            height: 4px;
            border-radius: 2px;
            background: rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { background: #EA4335; width: 25%; }
        .strength-fair { background: #FBBC04; width: 50%; }
        .strength-good { background: #34A853; width: 75%; }
        .strength-strong { background: #4285F4; width: 100%; }

        .strength-text {
            font-size: 0.8rem;
            font-weight: 500;
        }

        .password-tips {
            background: rgba(66, 133, 244, 0.1);
            border: 1px solid rgba(66, 133, 244, 0.3);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .password-tips h4 {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .password-tips ul {
            font-size: 0.85rem;
            color: #5f6368;
            margin-left: 1rem;
        }

        .password-tips li {
            margin-bottom: 0.25rem;
        }

        .password-button-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .password-button-group {
                flex-direction: column;
                align-items: stretch;
            }

            .password-btn {
                text-align: center;
                justify-content: center;
            }
        }
    </style>

    <form method="post" action="{{ route('password.update') }}" class="mt-6">
        @csrf
        @method('put')

        <div class="password-form-group">
            <label for="update_password_current_password" class="password-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                </svg>
                {{ __('Current Password') }}
            </label>
            <div class="password-input-container">
                <input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="password-input"
                    autocomplete="current-password"
                    placeholder="Enter your current password"
                />
                <button type="button" class="password-toggle" onclick="togglePassword('update_password_current_password')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="eye-open">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                </button>
            </div>
            @if($errors->updatePassword->has('current_password'))
                <div class="password-error">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="password-form-group">
            <label for="update_password_password" class="password-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                </svg>
                {{ __('New Password') }}
            </label>
            <div class="password-input-container">
                <input
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="password-input"
                    autocomplete="new-password"
                    placeholder="Enter your new password"
                    oninput="checkPasswordStrength(this.value)"
                />
                <button type="button" class="password-toggle" onclick="togglePassword('update_password_password')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="eye-open">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                </button>
            </div>
            <div id="password-strength" class="password-strength">
                <div class="strength-meter">
                    <div id="strength-fill" class="strength-fill"></div>
                </div>
                <div id="strength-text" class="strength-text"></div>
            </div>
            @if($errors->updatePassword->has('password'))
                <div class="password-error">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="password-form-group">
            <label for="update_password_password_confirmation" class="password-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
                {{ __('Confirm New Password') }}
            </label>
            <div class="password-input-container">
                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="password-input"
                    autocomplete="new-password"
                    placeholder="Confirm your new password"
                />
                <button type="button" class="password-toggle" onclick="togglePassword('update_password_password_confirmation')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="eye-open">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                </button>
            </div>
            @if($errors->updatePassword->has('password_confirmation'))
                <div class="password-error">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="password-tips">
            <h4>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                Password Security Tips
            </h4>
            <ul>
                <li>Use at least 8 characters</li>
                <li>Include uppercase and lowercase letters</li>
                <li>Add numbers and special characters</li>
                <li>Avoid common words or personal information</li>
            </ul>
        </div>

        <div class="password-button-group">
            <button type="submit" class="password-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                </svg>
                Update Password
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="password-success"
                    style="display: flex; align-items: center; gap: 0.5rem;"
                >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Password updated successfully!
                </div>
            @endif
        </div>
    </form>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.parentElement.querySelector('.password-toggle');
            const svg = button.querySelector('svg');

            if (input.type === 'password') {
                input.type = 'text';
                svg.innerHTML = '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>';
            } else {
                input.type = 'password';
                svg.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
            }
        }

        function checkPasswordStrength(password) {
            const strengthDiv = document.getElementById('password-strength');
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');

            if (password.length === 0) {
                strengthDiv.style.display = 'none';
                return;
            }

            strengthDiv.style.display = 'block';

            let strength = 0;
            let feedback = [];

            // Length check
            if (password.length >= 8) strength += 1;
            else feedback.push('at least 8 characters');

            // Uppercase check
            if (/[A-Z]/.test(password)) strength += 1;
            else feedback.push('uppercase letter');

            // Lowercase check
            if (/[a-z]/.test(password)) strength += 1;
            else feedback.push('lowercase letter');

            // Number check
            if (/[0-9]/.test(password)) strength += 1;
            else feedback.push('number');

            // Special character check
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            else feedback.push('special character');

            // Update visual feedback
            strengthFill.className = 'strength-fill';
            switch (strength) {
                case 0:
                case 1:
                    strengthFill.classList.add('strength-weak');
                    strengthText.textContent = 'Weak password';
                    strengthText.style.color = '#EA4335';
                    break;
                case 2:
                case 3:
                    strengthFill.classList.add('strength-fair');
                    strengthText.textContent = 'Fair password';
                    strengthText.style.color = '#FBBC04';
                    break;
                case 4:
                    strengthFill.classList.add('strength-good');
                    strengthText.textContent = 'Good password';
                    strengthText.style.color = '#34A853';
                    break;
                case 5:
                    strengthFill.classList.add('strength-strong');
                    strengthText.textContent = 'Strong password';
                    strengthText.style.color = '#4285F4';
                    break;
            }
        }
    </script>
</section>

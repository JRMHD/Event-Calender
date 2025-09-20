<section>
    <style>
        .delete-warning {
            background: linear-gradient(135deg, rgba(234, 67, 53, 0.1) 0%, rgba(234, 67, 53, 0.05) 100%);
            border: 1px solid rgba(234, 67, 53, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .delete-warning-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .delete-warning-icon {
            width: 40px;
            height: 40px;
            background: #EA4335;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .delete-warning-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #d32f2f;
        }

        .delete-warning-text {
            color: #5f6368;
            line-height: 1.6;
            font-size: 0.9rem;
        }

        .delete-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #EA4335 0%, #d33 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(234, 67, 53, 0.3);
            text-decoration: none;
        }

        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(234, 67, 53, 0.4);
            color: white;
        }

        .delete-btn:active {
            transform: translateY(0);
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal-overlay.show .modal-content {
            transform: scale(1);
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            background: #EA4335;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .modal-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .modal-text {
            color: #5f6368;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .modal-form-group {
            margin-bottom: 2rem;
        }

        .modal-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .modal-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(234, 67, 53, 0.2);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .modal-input:focus {
            outline: none;
            border-color: #EA4335;
            box-shadow: 0 0 0 3px rgba(234, 67, 53, 0.1);
            background: rgba(255, 255, 255, 0.95);
        }

        .modal-error {
            color: #EA4335;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .modal-btn-cancel {
            padding: 0.75rem 1.5rem;
            background: transparent;
            color: #5f6368;
            border: 2px solid #5f6368;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-btn-cancel:hover {
            background: #5f6368;
            color: white;
        }

        .modal-btn-delete {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #EA4335 0%, #d33 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(234, 67, 53, 0.3);
        }

        .modal-btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(234, 67, 53, 0.4);
        }

        @media (max-width: 768px) {
            .modal-content {
                padding: 1.5rem;
                margin: 1rem;
            }

            .modal-buttons {
                flex-direction: column;
            }

            .modal-btn-cancel,
            .modal-btn-delete {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="delete-warning">
        <div class="delete-warning-header">
            <div class="delete-warning-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                </svg>
            </div>
            <h3 class="delete-warning-title">Danger Zone</h3>
        </div>
        <p class="delete-warning-text">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain. This action cannot be undone.
        </p>
    </div>

    <button
        type="button"
        class="delete-btn"
        onclick="openDeleteModal()"
    >
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
        </svg>
        Delete Account
    </button>

    <!-- Modal -->
    <div id="deleteModal" class="modal-overlay" onclick="closeDeleteModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <div class="modal-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>
                </div>
                <h2 class="modal-title">Delete Account</h2>
            </div>

            <p class="modal-text">
                Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}" id="deleteForm">
                @csrf
                @method('delete')

                <div class="modal-form-group">
                    <label for="password" class="modal-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                        </svg>
                        Confirm with your password
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="modal-input"
                        placeholder="Enter your password to confirm"
                        required
                    />
                    @if($errors->userDeletion->has('password'))
                        <div class="modal-error">{{ $errors->userDeletion->first('password') }}</div>
                    @endif
                </div>

                <div class="modal-buttons">
                    <button type="button" class="modal-btn-cancel" onclick="closeDeleteModal()">
                        Cancel
                    </button>
                    <button type="submit" class="modal-btn-delete">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 0.5rem;">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                        </svg>
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('show');
            document.getElementById('password').focus();
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal(event) {
            if (event && event.target !== event.currentTarget) return;

            const modal = document.getElementById('deleteModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';

            // Clear the password field
            document.getElementById('password').value = '';
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Show modal if there are validation errors
        @if($errors->userDeletion->isNotEmpty())
            document.addEventListener('DOMContentLoaded', function() {
                openDeleteModal();
            });
        @endif
    </script>
</section>

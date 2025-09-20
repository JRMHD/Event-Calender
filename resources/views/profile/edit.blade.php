@extends('layouts.app')

@section('title', 'Profile Settings - Unity Group Calendar')
@section('page-title', 'Profile Settings')

@section('content')
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
        max-width: 800px;
        margin: 0 auto;
    }

    .profile-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.6) 100%);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        font-weight: 600;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #1a1a1a;
    }

    .card-description {
        color: #5f6368;
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(66, 133, 244, 0.1) 0%, rgba(52, 168, 83, 0.1) 100%);
        border-radius: 16px;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        background: var(--primary-blue);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 2rem;
        margin: 0 auto 1rem;
        box-shadow: 0 8px 20px rgba(66, 133, 244, 0.3);
    }

    .profile-name {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .profile-email {
        color: #5f6368;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .profile-role {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        background: rgba(52, 168, 83, 0.1);
        color: var(--primary-green);
        display: inline-block;
    }

    @media (max-width: 768px) {
        .profile-grid {
            padding: 0 1rem;
        }

        .profile-card {
            padding: 1.5rem;
        }

        .profile-name {
            font-size: 1.5rem;
        }

        .card-header {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="profile-header">
    <div class="profile-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
    <h1 class="profile-name">{{ auth()->user()->name }}</h1>
    <p class="profile-email">{{ auth()->user()->email }}</p>
    <div class="profile-role">{{ auth()->user()->role }}</div>
</div>

<div class="profile-grid">
    <div class="profile-card">
        <div class="card-header">
            <div class="card-icon" style="background: #4285F4;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <div>
                <h3 class="card-title">Profile Information</h3>
                <p class="card-description">Update your account's profile information and email address</p>
            </div>
        </div>
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="profile-card">
        <div class="card-header">
            <div class="card-icon" style="background: #34A853;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                </svg>
            </div>
            <div>
                <h3 class="card-title">Update Password</h3>
                <p class="card-description">Ensure your account is using a long, random password to stay secure</p>
            </div>
        </div>
        @include('profile.partials.update-password-form')
    </div>

    <div class="profile-card">
        <div class="card-header">
            <div class="card-icon" style="background: #EA4335;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                </svg>
            </div>
            <div>
                <h3 class="card-title">Delete Account</h3>
                <p class="card-description">Permanently delete your account and all associated data</p>
            </div>
        </div>
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection

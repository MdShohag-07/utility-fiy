@extends('layouts.app') {{-- Use the main public layout for header/footer --}}

@section('title', 'Reset Password')

@section('content')
<div class="forgot-password-page-container">
    <div class="container">
        <div class="forgot-password-content-box">

            <h1 class="page-main-title">Reset Password</h1>
            <p class="page-intro-text">Enter your email address to receive a password reset link.</p>

            <div class="form-section">
                <h2 class="form-section-title"><i class="fas fa-key"></i> Forgot your password?</h2>
                <p class="form-section-text">
                    No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </p>
                <p class="form-section-text small-text">
                    If you don't receive the email within a few minutes, please check your spam folder or try again.
                </p>

                <a href="{{ route('login') }}" class="back-to-login-link">
                    <i class="fa-solid fa-arrow-left-long"></i> Back to Log In
                </a>

                {{-- Form Title Inside Box --}}
                <h3 class="reset-form-title"><i class="fas fa-envelope"></i> Email Address <span class="required">*</span></h3>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4 forgot-session-status" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}"> {{-- Breeze route --}}
                    @csrf

                    <!-- Email Address Input -->
                    <div class="form-group forgot-password">
                         {{-- Label is now part of the H3 title --}}
                         <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email address" />
                         <x-input-error :messages="$errors->get('email')" class="mt-2 error-message" /> {{-- Ensure .error-message style exists --}}
                    </div>

                    <div class="form-actions forgot-password-actions">
                        <button type="submit" class="btn btn-primary forgot-password-button">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>

        </div> {{-- End forgot-password-content-box --}}
    </div> {{-- End container --}}
</div> {{-- End forgot-password-page-container --}}
@endsection

@push('styles')
{{-- Add page-specific styles --}}
<style>
    .forgot-password-page-container {
        padding: 60px 0; /* Add vertical padding */
        background-color: #f8f9fc; /* Light background */
        min-height: calc(100vh - 200px); /* Adjust based on header/footer height */
        display: flex;
        align-items: center; /* Vertically center content slightly */
    }
    .forgot-password-content-box {
        max-width: 800px; /* Limit width */
        margin: 0 auto; /* Center the box */
        background-color: #fff;
        padding: 40px 50px; /* Adjust padding */
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border: 1px solid #e0e0e0;
    }

    .page-main-title {
        font-size: 2.2rem; /* Larger title */
        font-weight: 700;
        color: #003a70; /* Darker blue */
        margin-bottom: 5px;
        text-align: center;
    }
    .page-intro-text {
        text-align: center;
        color: var(--text-color);
        margin-bottom: 35px;
        font-size: 1rem;
    }

    .form-section {
        margin-top: 20px;
        padding-top: 25px;
        border-top: 1px solid #eee;
    }

    .form-section-title {
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-section-title i { color: inherit; } /* Inherit title color */

    .form-section-text {
        font-size: 0.95rem;
        color: #555;
        line-height: 1.6;
        margin-bottom: 15px;
    }
    .form-section-text.small-text {
        font-size: 0.85rem;
        color: #777;
    }

    .back-to-login-link {
        display: inline-block;
        margin-bottom: 25px;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--primary-color);
    }
    .back-to-login-link i { margin-right: 5px; }
    .back-to-login-link:hover { text-decoration: underline; }

    .reset-form-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--heading-color);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .reset-form-title i { color: var(--medium-gray); }
    .reset-form-title .required { color: #d9534f; margin-left: 3px; font-weight: normal; font-size: 0.9em; }

    .form-group.forgot-password { margin-bottom: 20px; }
    .form-group.forgot-password .form-control {
        width: 100%;
        padding: 11px 15px; /* Adjust padding */
        border: 1px solid #aaa; /* Slightly darker border */
        border-radius: 4px;
        font-size: 1rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        background-color: #fff;
    }
    .form-group.forgot-password .form-control.is-invalid { border-color: #d9534f; }
    .form-group.forgot-password .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 94, 184, 0.15);
    }
    .error-message { color: #d9534f; font-size: 0.8rem; margin-top: 4px; }

    .form-actions.forgot-password-actions { margin-top: 25px; }
    .forgot-password-button {
        width: 100%; /* Full width button */
        padding: 12px 20px;
        font-size: 1rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        background: var(--primary-color); /* Use site's primary button style */
        color: var(--white-color);
        border: none;
        border-radius: 4px;
    }
    .forgot-password-button:hover {
        background: #004a9a;
        transform: translateY(-2px);
    }

    .forgot-session-status { /* Status message style */
        margin-bottom: 1rem; font-weight: 500; font-size: 0.9rem; color: #0f5132; background-color: #d1e7dd; padding: 12px 15px; border-left: 4px solid var(--success-color); border-radius: 4px;
    }

     /* Responsive */
    @media (max-width: 767px) {
        .forgot-password-content-box { padding: 30px 25px; }
        .page-main-title { font-size: 1.8rem; }
        .form-section-title { font-size: 1.4rem; }
        .reset-form-title { font-size: 1.1rem; }
    }
     @media (max-width: 480px) {
         .forgot-password-content-box { padding: 25px 15px; }
         .page-main-title { font-size: 1.6rem; }
         .form-section-title { font-size: 1.3rem; }
    }

</style>
@endpush
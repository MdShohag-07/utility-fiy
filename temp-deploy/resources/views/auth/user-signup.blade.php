@extends('layouts.app') {{-- Use the main layout with header/footer --}}

@section('title', 'Register Account') {{-- Set Page Title --}}

@section('content')
<div class="signup-page-container">
    <div class="container signup-content-wrapper"> {{-- Use standard container for content width --}}

        {{-- Left Column: Step Indicator --}}
        <aside class="signup-steps">
            <ul class="steps-list">
                {{-- Step 1 & 2 Visually Completed if verification link sent --}}
                <li class="step-item {{ session('status') === 'verification-link-sent' ? 'completed' : '' }}">
                    <div class="step-icon"><i class="fas fa-check"></i></div>
                    <div class="step-text">
                        <span class="step-title">Account Setup</span>
                    </div>
                </li>
                 <li class="step-item {{ session('status') === 'verification-link-sent' ? 'completed' : 'active' }}">
                    <div class="step-icon"><i class="{{ session('status') === 'verification-link-sent' ? 'fas fa-check' : 'fas fa-user' }}"></i></div>
                     <div class="step-text">
                        <span class="step-title">User Information</span>
                    </div>
                </li>
                {{-- Step 3: Email Verification (Active if link sent) --}}
                <li class="step-item {{ session('status') === 'verification-link-sent' ? 'active' : '' }}">
                     <div class="step-icon"><i class="fas fa-envelope"></i></div>
                     <div class="step-text">
                        <span class="step-title">Email Verification</span>
                    </div>
                </li>
                {{-- Step 4: Log In (Pending) --}}
                 <li class="step-item">
                     <div class="step-icon"><i class="fas fa-lock"></i></div>
                    <div class="step-text">
                        <span class="step-title">Complete</span>
                    </div>
                </li>
            </ul>
        </aside>

        {{-- Right Column: Form Area --}}
        <main class="signup-form-area">

            {{-- === CONDITIONAL DISPLAY === --}}
            @if (session('status') === 'verification-link-sent')

                {{-- Show Verification Message --}}
                <h1 class="form-title">Almost There! Verify Your Email</h1>
                <div class="signup-alert success"> {{-- Use a success style --}}
                    <i class="fas fa-check-circle"></i>
                    <div>
                        Registration successful! We've sent a verification link to your email address:
                        <strong>{{ session('signup_email', 'your email') }}</strong>.
                        <br><br>
                        Please click the link in that email to activate your account. If you don't see it, please check your spam folder.
                        <br><br>
                        <small>(You can close this page. You will be redirected after clicking the verification link.)</small>
                     </div>
                </div>
                {{-- Optional: Add a button to resend verification --}}
                 <form class="mt-4" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

            @else

                {{-- Show Registration Form --}}
                <h1 class="form-title">Register for {{ config('app.name', 'Our Service') }}</h1>

                <p class="form-intro attention-text">
                   <strong>Attention Paperless (eBill) Customers:</strong> If you receive your bill by email, you should already have a Username and
                    Password and you can simply <a href="{{ route('login') }}">Log In</a>. If you have forgotten your username or password, please click
                    <a href="{{ route('password.request') }}">Forgot Username</a> or <a href="{{ route('password.request') }}">Forgot Password</a>.
                </p>

                {{-- Display General Validation Errors --}}
                 @if ($errors->any() && !$errors->hasAny(['full_name', 'username', 'email', 'password', 'terms']))
                     <div class="signup-alert error">
                         <strong>Error:</strong> Please correct the issues identified below.
                     </div>
                 @endif

                <form method="POST" action="{{ route('user.signup.store') }}" id="signupForm">
                    @csrf

                    <h2 class="section-title">USER INFORMATION</h2>

                    <!-- Username -->
                    <div class="form-group signup">
                        <label for="username">Username <span class="required">*</span></label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required autocomplete="username" class="@error('username') input-error @enderror" aria-describedby="usernameHelp">
                        <small id="usernameHelp" class="form-text">Must be at least 7 characters using letters and numbers</small>
                        <x-input-error :messages="$errors->get('username')" class="mt-1 error-message" />
                    </div>

                     <!-- Full Name -->
                    <div class="form-group signup">
                        <label for="full_name">Full Name <span class="required">*</span></label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required autocomplete="name" class="@error('full_name') input-error @enderror">
                         <x-input-error :messages="$errors->get('full_name')" class="mt-1 error-message" />
                    </div>

                    <!-- Email Address -->
                    <div class="form-group signup">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="@error('email') input-error @enderror">
                         <x-input-error :messages="$errors->get('email')" class="mt-1 error-message" />
                    </div>

                    <!-- Confirm Email Address -->
                    <div class="form-group signup">
                        <label for="email_confirmation">Confirm Email <span class="required">*</span></label>
                        <input type="email" id="email_confirmation" name="email_confirmation" required autocomplete="email">
                         @error('email') @if ($message === 'The email confirmation does not match.') <div class="error-message mt-1">{{ $message }}</div> @endif @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group signup">
                        <label for="password">Password <span class="required">*</span></label>
                        <input type="password" id="password" name="password" required autocomplete="new-password" class="@error('password') input-error @enderror" aria-describedby="passwordHelp">
                         <small id="passwordHelp" class="form-text">Minimum 8 characters, case-sensitive. Include letters and numbers.</small>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 error-message" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group signup">
                        <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                          @error('password') @if ($message === 'The password confirmation does not match.') <div class="error-message mt-1">{{ $message }}</div> @endif @enderror
                    </div>

                     {{-- Note/Alert Box --}}
                    <div class="signup-note">
                        <i class="fas fa-leaf"></i>
                        <div>
                            <strong>Note:</strong> Creating an account may automatically enroll you in paperless billing (adjust text as needed). To manage preferences, log into your account after registration.
                        </div>
                    </div>

                    {{-- Terms and Conditions --}}
                    <h2 class="section-title terms-title">TERMS AND CONDITIONS</h2>
                     <div class="form-group signup terms-group">
                        <div class="terms-checkbox">
                            <input type="checkbox" id="terms" name="terms" value="accept" class="@error('terms') input-error @enderror">
                             <label for="terms">
                                 By registering, I agree to the {{ config('app.name', 'Service') }}'s <a href="/terms-of-service" target="_blank">Terms of Service</a>.<span class="required">*</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('terms')" class="mt-1 error-message" />
                    </div>

                    {{-- Action Buttons --}}
                    <div class="form-actions signup-actions">
                        <button type="submit" class="btn btn-primary btn-continue">Create Account</button>
                        <a href="{{ route('home') }}" class="btn btn-link btn-cancel-link">Cancel</a>
                    </div>

                </form>

            @endif {{-- End conditional display --}}

        </main>

    </div>
</div>
@endsection

@push('styles')
{{-- Styles from previous step remain the same --}}
{{-- Add styles for the verification success message --}}
<style>
    /* Existing signup styles... */
    .signup-alert.success {
        background-color: #d1e7dd; /* Light green */
        color: #0f5132; /* Dark green */
        border: 1px solid #badbcc;
        border-left: 4px solid var(--success-color, #2ecc71);
        padding: 20px;
        border-radius: var(--border-radius);
        margin-bottom: 20px;
        font-size: 1rem;
        display: flex; /* Align icon and text */
        align-items: flex-start;
        gap: 15px;
    }
    .signup-alert.success i {
        font-size: 1.5rem;
        margin-top: 3px;
        color: var(--success-color, #2ecc71);
    }
    .signup-alert.success strong {
        color: #0c4128; /* Slightly darker green for emphasis */
    }
    .signup-alert.success small {
        display: block;
        margin-top: 10px;
        font-size: 0.9em;
        color: #4f8f6f;
    }

     /* --- Signup Page V2 --- */
    .signup-page-container { padding: 40px 0; background-color: #f0f4f9; }
    .signup-content-wrapper { display: flex; flex-wrap: wrap; gap: 40px; background-color: #fff; padding: 35px 40px; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid #e0e0e0; }
    .signup-steps { flex: 0 0 200px; border-right: 1px solid #e0e0e0; padding-right: 40px; }
    .steps-list { list-style: none; padding: 0; margin: 0; position: relative; }
    .steps-list::before { content: ''; position: absolute; left: 16px; top: 15px; bottom: 15px; width: 2px; background-color: #e0e0e0; z-index: 1; }
    .step-item { display: flex; align-items: center; margin-bottom: 35px; position: relative; padding-left: 50px; min-height: 34px; color: #777; }
    .step-item .step-icon { position: absolute; left: 0; top: 0; width: 34px; height: 34px; border-radius: 50%; background-color: #fff; border: 2px solid #ccc; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #aaa; z-index: 2; transition: all 0.3s ease; }
    .step-item .step-text .step-title { font-weight: 500; display: block; line-height: 1.3; color: #777; transition: color 0.3s ease; font-size: 0.95rem; }
    .step-item.completed .step-icon { border-color: #2ecc71; background-color: #2ecc71; color: #fff; }
    .step-item.completed .step-text .step-title { color: #333; }
    .step-item.active .step-icon { border-color: #3498db; background-color: #3498db; color: #fff; transform: scale(1.05); }
    .step-item.active .step-text .step-title { color: #3498db; font-weight: 600; }
    .signup-form-area { flex: 1; min-width: 0; }
    .form-title { font-size: 1.7rem; font-weight: 600; color: #003a70; margin-bottom: 20px; }
    .form-intro { color: #444; margin-bottom: 25px; font-size: 0.9rem; line-height: 1.6; }
    .attention-text { border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 25px; }
    .form-intro a { color: #0056b3; text-decoration: underline; } .form-intro a:hover { color: #003a70; }
    .section-title { font-size: 0.9rem; font-weight: 700; color: #0056b3; margin-top: 25px; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #eee; text-transform: uppercase; letter-spacing: 0.5px; }
    .terms-title { margin-top: 30px; border-bottom: none; }
    .form-group.signup { margin-bottom: 16px; }
    .form-group.signup label { display: block; margin-bottom: 5px; font-weight: 500; font-size: 0.85rem; color: #555; }
    .form-group.signup label .required { color: #d9534f; margin-left: 3px; font-weight: normal; }
    .form-group.signup input[type="text"], .form-group.signup input[type="email"], .form-group.signup input[type="password"] { width: 100%; padding: 9px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 0.95rem; font-family: var(--font-admin); transition: border-color 0.2s ease, box-shadow 0.2s ease; background-color: #fdfdfd; }
    .form-group.signup input:focus { outline: none; border-color: #66afe9; box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2); }
    .form-group.signup input.input-error { border-color: #d9534f; }
    .form-text { display: block; margin-top: 4px; font-size: 0.8rem; color: #777; }
    .error-message { color: #d9534f; font-size: 0.8rem; margin-top: 4px; }
    .signup-note { background-color: #e7f3fe; border-left: 4px solid #66afe9; padding: 15px; margin: 25px 0; display: flex; gap: 10px; border-radius: 4px; font-size: 0.85rem; line-height: 1.5; color: #31708f; }
    .signup-note i { color: #66afe9; font-size: 1.1rem; margin-top: 2px; }
    .signup-note strong { color: #31708f; }
    .terms-group { margin-top: 10px; }
    .terms-checkbox { display: flex; align-items: center; }
    .terms-checkbox input[type="checkbox"] { margin-right: 8px; width: 15px; height: 15px; flex-shrink: 0; border-color: #aaa; }
    .terms-checkbox label { margin-bottom: 0; font-weight: normal; font-size: 0.85rem; color: #555; }
    .terms-checkbox label a { color: #0056b3; text-decoration: underline; }
    .terms-checkbox label a:hover { color: #003a70; }
    .signup-actions { margin-top: 25px; padding-top: 15px; border-top: 1px solid #eee; display: flex; justify-content: flex-end; align-items: center; gap: 15px; }
    .btn-continue { min-width: 150px; padding: 11px 25px; font-size: 1rem; }
    .btn-cancel-link { background: none; border: none; color: #0056b3; font-size: 0.9rem; text-decoration: underline; padding: 10px 0; }
    .btn-cancel-link:hover { color: #003a70; }
    .signup-alert.error { background-color: #f2dede; color: #a94442; border: 1px solid #ebccd1; padding: 12px 15px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9rem; }
    @media (max-width: 991px) { .signup-content-wrapper { flex-direction: column; padding: 25px 30px;} .signup-steps { flex-basis: auto; width: 100%; border-right: none; border-bottom: 1px solid #e0e0e0; padding-right: 0; padding-bottom: 20px; margin-bottom: 25px; } .steps-list { display: flex; justify-content: space-around; } .steps-list::before { display: none; } .step-item { flex-direction: column; align-items: center; text-align: center; padding-left: 0; margin-bottom: 0; flex: 1; } .step-item .step-icon { position: static; margin-bottom: 8px; } .step-item .step-text .step-title { font-size: 0.8rem; } }
    @media (max-width: 480px) { .form-title { font-size: 1.4rem; } .signup-content-wrapper { padding: 20px 15px; } .signup-steps { padding-bottom: 15px; } .step-item .step-icon { width: 30px; height: 30px; font-size: 0.9rem;} .form-group.signup label { font-size: 0.8rem; } .signup-actions { flex-direction: column-reverse; align-items: stretch; } .signup-actions .btn { width: 100%; } }
</style>
@endpush
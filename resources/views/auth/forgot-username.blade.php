@extends('layouts.app') {{-- Use the main public layout --}}

@section('title', 'Forgot Username')

@section('content')
<div class="simple-page-container">
    <div class="container">
        <div class="simple-content-box">

            <h1 class="page-main-title">Forgot Username</h1>
            <p class="page-intro-text">Can't remember your username? Follow these steps to recover it.</p>

            <div class="steps-container">
                <h2 class="info-section-title">How to find your username?</h2>

                {{-- Step 1: Check Emails --}}
                <div class="step-item-v2 step-email"> {{-- Added step-email class --}}
                    <div class="step-number-v2">1</div> {{-- Simplified number container --}}
                    <div class="step-content">
                        <h4 class="step-title-v2">Check Your Emails</h4>
                        <p class="step-description">
                            Search your email inbox (including spam/junk folders) for a "Welcome" or "Account Created" email from "{{ config('app.name', 'us') }}". Your chosen username might be mentioned there.
                        </p>
                    </div>
                </div>

                {{-- Step 2: Try Email Login --}}
                <div class="step-item-v2 step-login-alt"> {{-- Added step-login-alt class --}}
                    <div class="step-number-v2">2</div> {{-- Simplified number container --}}
                    <div class="step-content">
                        <h4 class="step-title-v2">Try Logging In With Email</h4>
                        <p class="step-description">
                            Good news! You can usually <a href="{{ route('login') }}">log in</a> using your registered email address instead of your username. Give that a try first.
                        </p>
                    </div>
                </div>

                {{-- Step 3: Contact Support --}}
                <div class="step-item-v2 step-support"> {{-- Added step-support class --}}
                   <div class="step-number-v2">3</div> {{-- Simplified number container --}}
                    <div class="step-content">
                        <h4 class="step-title-v2">Contact Support</h4>
                        <p class="step-description">
                            If the steps above don't help, please contact our support team. You may need to verify your identity for security reasons.
                            {{-- Example: <a href="/contact-us">Contact Support</a> --}}
                        </p>
                    </div>
                </div>

            </div> {{-- End steps-container --}}

            <a href="{{ route('login') }}" class="back-to-login-link" style="margin-top: 30px;">
                <i class="fa-solid fa-arrow-left-long"></i> Back to Log In
            </a>

        </div> {{-- End simple-content-box --}}
    </div> {{-- End container --}}
</div> {{-- End simple-page-container --}}
@endsection

@push('styles')
{{-- Add page-specific styles --}}
<style>
    .simple-page-container { padding: 60px 0; background-color: #f8f9fc; min-height: calc(100vh - 200px); display: flex; align-items: center; }
    .simple-content-box { max-width: 850px; margin: 0 auto; background-color: #fff; padding: 40px 50px; border-radius: 6px; box-shadow: 0 4px 15px rgba(0,0,0,0.07); border: 1px solid #e0e0e0; }
    .page-main-title { font-size: 2.1rem; font-weight: 700; color: #003a70; margin-bottom: 8px; text-align: left; }
    .page-intro-text { text-align: left; color: var(--text-color); margin-bottom: 35px; font-size: 1rem; padding-bottom: 20px; border-bottom: 1px solid #eee; }
    .steps-container { margin-top: 30px; }
    .info-section-title { font-size: 1.5rem; font-weight: 600; color: var(--primary-color); margin-bottom: 25px; }

    /* --- Updated Step Styles (No Icons) --- */
    .step-item-v2 {
        display: flex;
        align-items: flex-start; /* Align number top */
        gap: 15px; /* Reduced gap */
        background-color: #fdfdff;
        border: 1px solid var(--border-color);
        border-left: 5px solid var(--primary-admin-color); /* Default accent */
        padding: 18px 20px; /* Adjusted padding */
        border-radius: var(--border-radius);
        margin-bottom: 18px; /* Slightly less margin */
        transition: background-color 0.2s ease, border-left-color 0.2s ease, box-shadow 0.2s ease; /* Added background transition */
    }
    /* Hover effect */
    .step-item-v2:hover {
        background-color: #f5f9fc; /* Light blue tint on hover */
        box-shadow: 0 2px 5px rgba(0,0,0,0.05); /* Subtle shadow on hover */
    }

    /* Specific accent colors */
    .step-item-v2.step-email { border-left-color: var(--success-color); }
    .step-item-v2.step-login-alt { border-left-color: var(--warning-color); }
    .step-item-v2.step-support { border-left-color: var(--purple-color, #8e44ad); }

    /* Step Number Styling */
    .step-number-v2 {
        flex-shrink: 0;
        width: 30px; /* Smaller circle */
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 600;
        color: var(--white-color);
        background-color: var(--primary-admin-color); /* Default number background */
        margin-top: 2px; /* Align slightly better with text */
    }
    /* Specific number background colors */
    .step-item-v2.step-email .step-number-v2 { background-color: darkseagreen; }
    .step-item-v2.step-login-alt .step-number-v2 { background-color: cornflowerblue; }
    .step-item-v2.step-support .step-number-v2 { background-color: var(--purple-color, #8e44ad); }


    .step-content { flex-grow: 1; }
    .step-title-v2 { font-size: 1.1rem; font-weight: 600; color: var(--heading-color); margin-top: 0; margin-bottom: 6px; }
    .step-description { font-size: 0.9rem; color: var(--text-color); line-height: 1.6; margin-bottom: 0; }
    .step-description a { font-weight: 500; text-decoration: underline; }

    .back-to-login-link { display: inline-block; margin-top: 30px; font-size: 0.9rem; font-weight: 500; color: var(--primary-color); }
    .back-to-login-link i { margin-right: 5px; } .back-to-login-link:hover { text-decoration: underline; }

    /* --- Removed Explicit Font Awesome Rules --- */
    /* .step-icon-v2 > i.fa-solid { ... } */
    /* .step-icon-v2 > i.fa-solid::before { ... } */

    @media (max-width: 767px) { .simple-content-box { padding: 30px 25px; } .page-main-title { font-size: 1.8rem; } .info-section-title { font-size: 1.4rem; } .step-item-v2 { padding: 15px; } .step-title-v2 { font-size: 1.05rem; } }
    @media (max-width: 480px) { .simple-page-container { padding: 40px 0; } .simple-content-box { padding: 25px 15px; } .page-main-title { font-size: 1.6rem; } .info-section-title { font-size: 1.2rem; } .step-title-v2 { font-size: 1rem;} .step-description { font-size: 0.85rem;} }
</style>
@endpush
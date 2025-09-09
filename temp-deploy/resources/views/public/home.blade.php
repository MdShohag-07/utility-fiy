{{-- resources/views/public/home.blade.php --}}
@extends('layouts.app')

@section('title', $settings['site_name'] ?? config('app.name', 'Utility Site'))

@section('content')
    <div class="user-dashboard-layout public-home-dashboard">

        @include('partials.public_home_sidebar') {{-- Include the updated sidebar --}}

        <main class="dashboard-main-content">

            {{-- Section 1: Account / Sign In + Promo Image --}}
            <section class="account-section py-5 mb-6 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="container mx-auto grid md:grid-cols-2 gap-8 items-center px-4 md:px-6">
                    <div class="account-text-content">
                        <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-3">{{ $settings['hp_account_headline'] ?? 'Your Account at Your Fingertips' }}</h2>
                        <p class="text-base text-gray-600 mb-6">{{ $settings['hp_account_subtext'] ?? 'Sign in for the easiest way to pay your bill, manage your account, watch TV anywhere and more.' }}</p>
                         <div class="flex flex-wrap gap-3 mb-4">
                            <a href="{{ route('signup') }}" class="btn btn-outline-primary">{{ $settings['hp_account_create_text'] ?? 'Create a Username' }}</a>
                            <a href="{{ route('login') }}" class="btn btn-primary">{{ $settings['hp_account_signin_text'] ?? 'Sign In' }}</a>
                        </div>
                        <p class="text-sm text-gray-600"> {{ $settings['hp_account_notcustomer_text'] ?? 'Not a Spectrum Customer?' }} <a href="{{ $settings['hp_account_getstarted_url'] ?? '#' }}" class="text-blue-600 hover:underline font-medium">{{ $settings['hp_account_getstarted_text'] ?? 'Get Started' }}</a> </p>
                    </div>
                    <div class="account-image-content text-center hidden md:block">
                         <img src="{{ $settings['hp_account_image_url'] ?? asset('images/placeholders/spectrum-account-promo.png') }}" alt="Account devices" class="inline-block max-w-sm h-auto rounded">
                    </div>
                </div>
            </section>

            {{-- Section 2: Internet Promo --}}
            {{-- *** UPDATED: Removed background/text color, changed structure *** --}}
            <section class="internet-section py-12 md:py-16 mb-6 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="container mx-auto grid md:grid-cols-2 gap-8 items-center px-4 md:px-6">

                    {{-- Column 1: Image (NOW FIRST) --}}
                    <div class="internet-section-image text-center">
                        <img src="{{ $settings['hp_internet_bg_image_url'] ?? asset('images/placeholders/spectrum-internet-bg.jpg') }}" alt="Reliably Fast Internet" class="inline-block max-w-md h-auto rounded"> {{-- Adjusted max-width --}}
                    </div>

                    {{-- Column 2: Text (NOW SECOND) --}}
                    <div class="internet-section-text"> {{-- Changed text color classes will likely be needed --}}
                        <h2 class="text-2xl md:text-3xl font-semibold mb-4 leading-tight text-gray-800">{{ $settings['hp_internet_headline'] ?? 'Reliably Fast Internet. Incredible Savings.' }}</h2>
                        <p class="text-base mb-6 text-gray-600">{{ $settings['hp_internet_subtext'] ?? 'Switch to Spectrum for the fastest, most reliable Internet. Add Spectrum Mobile® to enjoy seamless connectivity wherever you go.' }}</p>
                        <a href="{{ $settings['hp_internet_button_url'] ?? '#' }}" class="btn btn-primary">{{ $settings['hp_internet_button_text'] ?? 'See My Deals' }}</a>
                        <p class="text-xs text-gray-500 mt-4">{{ $settings['hp_internet_disclaimer'] ?? 'Services not available in all areas. Restrictions apply.' }}</p>
                    </div>

                </div>
            </section>
            {{-- *** END Internet Section Update *** --}}

        </main>

        @auth
            @include('partials.user_mobile_nav', ['active' => 'home'])
        @endauth

    </div>
@endsection

@push('styles')
<style>
    .public-home-dashboard .dashboard-main-content { padding: 1rem; background-color: var(--light-gray); }
    @media (min-width: 768px) { .public-home-dashboard .dashboard-main-content { padding: 1.5rem; } }
    .public-home-dashboard .dashboard-sidebar { border-right: 1px solid var(--border-color, #e5e7eb); background-color: #f8f9fa; }
    .account-section h2 { color: #111; }
    /* Styles for internet section */
    .internet-section { /* No specific background needed anymore */ }
    .internet-section-text h2 { color: #111; /* Dark text on white bg */ }
    .internet-section-text p { color: #555; /* Standard paragraph color */ }
    .internet-section-text .btn-primary { /* Keep primary button style */ }
</style>
@endpush

@push('scripts')
@endpush
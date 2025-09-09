@extends('layouts.app')

@section('content')

    {{-- Paste ALL <section> elements from your final public index.html here --}}
    {{-- !! IMPORTANT !! --}}
    {{-- 1. Change ALL image src="..." to src="{{ asset('images/...') }}" --}}
    {{-- 2. Change the login form action="..." to action="{{ route('login') }}" (or appropriate route) --}}
    {{-- 3. Add @csrf inside the login form --}}

    {{-- Example: Hero Section --}}
    <section class="hero">
        <div class="hero-background" style="background-image: url('{{ asset('https://cdn-ildjbmb.nitrocdn.com/HHdldcOjYvLIikpqXVsJfxJLusLVDrKo/assets/images/optimized/rev-1fc40b8/www.ouc.com/wp-content/uploads/2025/02/OUC.com-Hero-New-Site.webp') }}')">
            {{-- Use inline style for CSS background image or adjust CSS --}}
        </div>
        <div class="container hero-content">
            <div class="hero-text">
                <h1>{{ $heroTitle ?? 'Recognized Excellence in Service' }}</h1>
                <p>{{ $heroSubtitle ?? 'Your trusted hometown provider leading the way in customer satisfaction.' }}</p>
                <a href="#" class="btn btn-primary">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
        </div>
        <div class="hero-indicators">
            <span></span><span class="active"></span><span></span><span></span>
        </div>
    </section>

    {{-- Login & Quick Links Section --}}
    <section id="login-section" class="login-quicklinks">
        <div class="container login-quicklinks-grid">
            <div class="login-form-container">
                <h2>Log in to MyAccount</h2>
                 {{-- Update action when login route is fully implemented --}}
                 {{-- Add method="POST" --}}
                <form action="{{ route('login') }}" method="POST">
                     @csrf {{-- Add CSRF Token --}}
                    <div class="form-group">
                        <label for="username">Username</label> {{-- Consider using 'email' --}}
                        <input type="text" id="username" name="email" placeholder="Enter Email" required value="{{ old('email') }}">
                        @error('email') <span class="error-message">{{ $message }}</span> @enderror {{-- Add error display --}}
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Enter Password" required>
                            <button type="button" class="toggle-password" aria-label="Show password">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                         @error('password') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-links">
                        <a href="#">Forgot Username?</a>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Log In</button>
                    <a href="#" class="register-link">Register <i class="fa-solid fa-arrow-right-long"></i></a> {{-- Link to register route later --}}
                </form>
            </div>
            <div class="quick-links-container">
                {{-- Add proper links later --}}
                <a href="#" class="quick-link-button">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>Pay My Bill</span>
                    <i class="fa-solid fa-arrow-right-long arrow"></i>
                </a>
                <a href="#" class="quick-link-button">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Report an Outage or Problem</span>
                    <i class="fa-solid fa-arrow-right-long arrow"></i>
                </a>
                 <a href="#" class="quick-link-button">
                    <i class="fa-solid fa-truck-fast"></i>
                    <span>Start / Stop / Move Service</span>
                    <i class="fa-solid fa-arrow-right-long arrow"></i>
                </a>
                <a href="#" class="quick-link-button">
                     <i class="fa-regular fa-envelope"></i>
                    <span>Contact Us</span>
                    <i class="fa-solid fa-arrow-right-long arrow"></i>
                </a>
                 <a href="#" id="view-statement-link" class="quick-link-button">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>View Billing Statement</span>
                    <i class="fa-solid fa-arrow-right-long arrow"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- Important Resources Section --}}
    <section class="resources">
        <div class="container">
             <h2>Important Resources</h2>
             <div class="resources-grid">
                <div class="resource-card">
                     <i class="fa-solid fa-bell icon"></i>
                     <h3>Set Up Alerts</h3>
                     <p>Receive notifications about your usage and bill reminders.</p>
                     <a href="#" class="btn btn-secondary">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                 </div>
                 <div class="resource-card">
                     <i class="fa-solid fa-hand-holding-dollar icon"></i>
                     <h3>Payment Assistance</h3>
                     <p>Options when you need more time to pay your bill.</p>
                     <a href="#" class="btn btn-secondary">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                 </div>
                 <div class="resource-card">
                     <i class="fa-solid fa-percent icon"></i>
                     <h3>Find Rebates</h3>
                     <p>Get cash back for home upgrades, appliances and more.</p>
                     <a href="#" class="btn btn-secondary">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                 </div>
             </div>
         </div>
    </section>

    {{-- Featured Content Section --}}
    <section class="featured-content">
        <div class="container featured-content-grid">
            <div class="content-card">
                 <img src="{{ asset('https://cdn-ildjbmb.nitrocdn.com/HHdldcOjYvLIikpqXVsJfxJLusLVDrKo/assets/images/optimized/rev-1fc40b8/www.ouc.com/wp-content/uploads/2024/12/GetGreenMKT.webp') }}" alt="House made of money">
                 <div class="card-body">
                     <h3>Don't Just Go Green—Get Green</h3>
                     <p>It pays to have a greener home. When you upgrade, repair or replace your energy-related home appliances, you can lower your overall costs and up your savings.</p>
                     <a href="#" class="learn-more-link">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                 </div>
             </div>
             <div class="content-card">
                 <img src="{{ asset('https://cdn-ildjbmb.nitrocdn.com/HHdldcOjYvLIikpqXVsJfxJLusLVDrKo/assets/images/optimized/rev-1fc40b8/www.ouc.com/wp-content/uploads/2024/12/RobinsonHub.webp') }}" alt="EV charging station">
                 <div class="card-body">
                     <h3>Our ReCharge Mobility Hubs</h3>
                     <p>Equipped with cutting-edge DC Fast chargers (DCFC), our hubs provide seamless, hassle-free charging for all types of EVs.</p>
                     <a href="#" class="learn-more-link">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                 </div>
             </div>
        </div>
    </section>

    {{-- Careers Section --}}
    <section class="careers">
         <div class="container careers-grid">
             <div class="careers-image">
                  <img src="{{ asset('https://cdn-ildjbmb.nitrocdn.com/HHdldcOjYvLIikpqXVsJfxJLusLVDrKo/assets/images/optimized/rev-1fc40b8/www.ouc.com/wp-content/uploads/2024/12/Careers-Image-OUC-1.webp') }}" alt="Utility worker">
             </div>
             <div class="careers-text">
                 <h2>Explore Our Careers</h2>
                 <p>Power your future with a career at [Your Company Name]! Explore opportunities in professional, skilled trades, and leadership roles, and grow with a company that empowers you to succeed.</p>
                 <a href="#" class="btn btn-primary">See Job Openings <i class="fa-solid fa-arrow-right-long"></i></a>
             </div>
         </div>
    </section>

    {{-- Customer Solutions & Programs Section --}}
    <section class="solutions-programs">
        <div class="container">
             <h2>Customer Solutions and Programs</h2>
             <div class="solutions-slider">
                 <div class="solution-card">
                      <img src="{{ asset('https://cdn-ildjbmb.nitrocdn.com/HHdldcOjYvLIikpqXVsJfxJLusLVDrKo/assets/images/optimized/rev-1fc40b8/www.ouc.com/wp-content/uploads/2024/11/electric-vehicle.webp') }}" alt="Electric Vehicle">
                     <h3>Electric Vehicle Programs</h3>
                     <p>A variety of programs for EV drivers and fleet managers.</p>
                     <a href="#" class="learn-more-link">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                 </div>
                 <div class="solution-card">
                     <img src="{{ asset('https://cdn-ildjbmb.nitrocdn.com/HHdldcOjYvLIikpqXVsJfxJLusLVDrKo/assets/images/optimized/rev-1fc40b8/www.ouc.com/wp-content/uploads/2024/11/electric-vehicle.webp') }}" alt="House exterior">
                     <h3>Home Warranty Programs</h3>
                     <p>Protection from risks not covered by homeowners' insurance.</p>
                     <a href="#" class="learn-more-link">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                 </div>
                 <div class="solution-card">
                     <img src="{{ asset('https://cdn-ildjbmb.nitrocdn.com/HHdldcOjYvLIikpqXVsJfxJLusLVDrKo/assets/images/optimized/rev-1fc40b8/www.ouc.com/wp-content/uploads/2024/11/electric-vehicle.webp') }}" alt="Cityscape">
                     <h3>Business Solutions</h3>
                     <p>Innovative programs and services for commercial customers.</p>
                      <a href="#" class="learn-more-link">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                 </div>
             </div>
             <div class="slider-nav">
                 <button class="slider-prev"><i class="fa-solid fa-arrow-left-long"></i></button>
                 <span>1 of 2</span>
                 <button class="slider-next"><i class="fa-solid fa-arrow-right-long"></i></button>
             </div>
         </div>
    </section>

    {{-- News & Updates Section --}}
    <section class="news-updates">
        <div class="container">
             <h2>Stay Informed with News and Updates</h2>
             <div class="news-grid">
                 <div class="content-card">
                     <img src="{{ asset('https://cdn-ildjbmb.nitrocdn.com/HHdldcOjYvLIikpqXVsJfxJLusLVDrKo/assets/images/optimized/rev-1fc40b8/www.ouc.com/wp-content/uploads/2024/11/Newsroom-Image-Two.webp') }}" alt="Technician working">
                     <div class="card-body">
                         <h3>Newsroom</h3>
                         <p>Discover how we are constantly working to improve reliability for our customers.</p>
                         <a href="#" class="learn-more-link">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                     </div>
                 </div>
                 <div class="content-card">
                      <img src="{{ asset('https://cdn-ildjbmb.nitrocdn.com/HHdldcOjYvLIikpqXVsJfxJLusLVDrKo/assets/images/optimized/rev-1fc40b8/www.ouc.com/wp-content/uploads/2024/11/Newsroom-Image-Two.webp') }}" alt="Drone inspecting power line">
                     <div class="card-body">
                         <h3>Our Blog</h3>
                         <p>Learn about our remarkable people, innovative programs and commitment to deliver affordable, reliable, sustainable service.</p>
                         <a href="#" class="learn-more-link">Learn More <i class="fa-solid fa-arrow-right-long"></i></a>
                     </div>
                 </div>
             </div>
         </div>
    </section>


@endsection

@push('scripts')
    {{-- Add page-specific scripts for sliders, etc. later --}}
    {{-- <script src="{{ asset('js/slider.js') }}"></script> --}}
@endpush

@push('styles')
    {{-- Add page-specific styles if needed --}}
    <style>
        .error-message { color: #e74c3c; font-size: 0.85rem; margin-top: 4px; display: block;}
    </style>
@endpush
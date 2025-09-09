{{-- resources/views/partials/public_footer.blade.php --}}
{{-- New structure based on Spectrum screenshot, wave removed --}}

<footer class="spectrum-footer">
    <div class="footer-container container mx-auto"> {{-- Use your container class --}}

        {{-- Footer Navigation Columns --}}
        <div class="footer-nav-columns">
            {{-- Column 1: Get Support --}}
            <div class="footer-nav-col">
                <h4>Get Support</h4>
                <ul>
                    {{-- TODO: Make these links dynamic (Menu Manager location='footer_support'?) --}}
                    <li><a href="#">Account & Billing</a></li>
                    <li><a href="#">Internet</a></li>
                    <li><a href="#">TV</a></li>
                    <li><a href="#">Home Phone</a></li>
                    <li><a href="#">Mobile</a></li>
                    <li><a href="#">Accessibility</a></li>
                </ul>
            </div>

            {{-- Column 2: Watch TV --}}
            <div class="footer-nav-col">
                <h4>Watch TV</h4>
                 <ul>
                    {{-- TODO: Make these links dynamic --}}
                    <li><a href="#">Live TV</a></li>
                    <li><a href="#">Guide</a></li>
                    <li><a href="#">My Library</a></li>
                    <li><a href="#">On Demand</a></li>
                    <li><a href="#">DVR</a></li>
                </ul>
            </div>

            {{-- Column 3: Quick Links & Social --}}
            <div class="footer-nav-col">
                {{-- Using Font Awesome Icons inline --}}
                 <ul class="footer-icon-links">
                     {{-- TODO: Make these links dynamic --}}
                    <li><a href="#"><i class="fas fa-map-marker-alt fa-fw"></i> Find a Spectrum Store</a></li>
                    <li><a href="#"><i class="fas fa-bolt fa-fw"></i> Get Weather Outage Info</a></li>
                    <li><a href="#"><i class="fas fa-heart fa-fw"></i> Customer Commitment</a></li>
                    <li><a href="#"><i class="fas fa-leaf fa-fw"></i> Get Energy Use Info</a></li>
                    <li><a href="#"><i class="fas fa-comments fa-fw"></i> Chat With Spectrum</a></li>
                    <li><a href="#"><i class="fas fa-phone-alt fa-fw"></i> Contact Us</a></li>
                 </ul>
                 {{-- Social Icons --}}
                 <div class="footer-social-icons">
                     {{-- TODO: Make these links dynamic (from settings?) --}}
                     <a href="#" aria-label="Spectrum Twitter/X"><i class="fab fa-twitter"></i></a>
                     <a href="#" aria-label="Spectrum Facebook"><i class="fab fa-facebook-f"></i></a>
                     <a href="#" aria-label="Spectrum Instagram"><i class="fab fa-instagram"></i></a>
                     <a href="#" aria-label="Spectrum Youtube"><i class="fab fa-youtube"></i></a>
                 </div>
            </div>
        </div> {{-- End Footer Navigation Columns --}}

         <hr class="footer-divider">

         {{-- Footer Shop Services Links --}}
         <div class="footer-shop-services">
            <h4>Shop Spectrum Services</h4>
             <nav>
                 <ul>
                     {{-- TODO: Make these links dynamic --}}
                    <li><a href="#">Internet</a></li>
                    <li><a href="#">TV</a></li>
                    <li><a href="#">Home Phone</a></li>
                    <li><a href="#">Mobile</a></li>
                    <li><a href="#">Spectrum Business</a></li>
                 </ul>
             </nav>
         </div>

         <hr class="footer-divider">

         {{-- Footer Bottom Links & Copyright --}}
         <div class="footer-bottom-section">
             <div class="footer-bottom-logo">
                  {{-- Using Charter logo placeholder - replace with dynamic logo if needed --}}
                  {{-- If using the main site logo, use $siteLogoUrl here instead --}}
                  <img src="{{ asset('images/placeholders/charter-logo.svg') }}" alt="Charter Communications">
             </div>
             <div class="footer-bottom-links">
                  {{-- TODO: Make these links dynamic (Menu Manager location='footer_legal'?) --}}
                 <span>© {{ date('Y') }} Charter Communications</span> |
                 <a href="#">Your Privacy Rights</a> |
                 <a href="#">California Consumer Privacy Rights</a> |
                 <a href="#">Do Not Sell or Share My Personal Information / Opt-Out of Targeted Advertising</a> |
                 <a href="#">Service Rates and Disclosures</a> |
                 <a href="#">Policies</a> |
                 <a href="#">California Consumer Limit the Use of My Sensitive Personal Information</a> |
                 <a href="#">Open Source Libraries</a>
             </div>
         </div>

    </div> {{-- End Footer Container --}}

    {{-- Wave background DIV removed --}}

</footer>
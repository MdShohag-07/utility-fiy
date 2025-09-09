<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\MenuLink;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The cache key used for storing all shared site data.
     * Controllers MUST use this exact key when calling Cache::forget().
     */
    public const SHARED_DATA_CACHE_KEY = 'shared_site_data_v1'; // Added v1 in case you need to bust all old caches

    public function register(): void
    {
        if ($this->app->environment('production')) {
            // Example: $this->app->usePublicPath(base_path('../public_html'));
        }
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Default values
            $defaultSiteLogoUrl = asset('images/placeholder-logo.png'); // Fallback logo

            // Fetch shared data (settings and menus) from cache or DB
            $sharedData = Cache::remember(self::SHARED_DATA_CACHE_KEY, now()->addMinutes(60), function () {
                Log::info('AppServiceProvider: Rebuilding cache for key: ' . self::SHARED_DATA_CACHE_KEY);
                $dbSettingsResult = [];
                $menuDataResult = ['header' => collect(), 'secondary' => collect(), 'footer' => collect()];

                if (Schema::hasTable('settings')) {
                    // Define ALL setting keys needed globally: site settings, homepage content, AND PDF content
                    $settingKeys = [
                        // General Site Settings
                        'site_name',
                        'site_logo', // Stores path to logo
                        'footer_text',
                        'header_bg_color', // Example from SiteSettingsController

                        // Homepage Content Keys (hp_*)
                        'hp_hero_headline', 'hp_hero_subheadline', 'hp_hero_button_text', 'hp_hero_button_url', 'hp_hero_image',
                        'hp_account_headline', 'hp_account_subtext', 'hp_account_create_text', 'hp_account_create_url',
                        'hp_account_signin_text', 'hp_account_notcustomer_text', 'hp_account_getstarted_text',
                        'hp_account_getstarted_url', 'hp_account_image',
                        'hp_internet_headline', 'hp_internet_subtext', 'hp_internet_button_text', 'hp_internet_button_url',
                        'hp_internet_disclaimer', 'hp_internet_bg_image',
                        // TODO: Add keys for other homepage sections if they exist (Resources, Features etc.)

                        // PDF Content Setting Keys (pdf_*)
                        'pdf_important_news_section_title',
                        'pdf_important_news_title1', 'pdf_important_news_text1', 'pdf_important_news_url1_text', 'pdf_important_news_url1',
                        'pdf_important_news_title2', 'pdf_important_news_text2', 'pdf_important_news_url2_text', 'pdf_important_news_url2',
                        'pdf_unlimited_calling_title', 'pdf_unlimited_calling_text', 'pdf_unlimited_calling_phone_text',
                        'pdf_unlimited_calling_phone', 'pdf_unlimited_calling_suffix',
                        'pdf_payment_stub_note_prefix', 'pdf_customer_service_phone', 'pdf_payment_stub_note_suffix',
                        'pdf_return_address_warning_brand', 'pdf_return_address_warning_text',
                        'pdf_return_address_co_name', 'pdf_return_address_line1', 'pdf_return_address_line2',
                        'pdf_payment_recipient_name', 'pdf_payment_address_line1', 'pdf_payment_address_line2',
                        // PDF Page 2 Keys
                        'pdf_autopay_url_link', 'pdf_autopay_url_text',
                        'pdf_online_billing_url_link', 'pdf_online_billing_url_text',
                        'pdf_paperless_url_link', 'pdf_paperless_url_text',
                        'pdf_phone_payment_number_tel', 'pdf_phone_payment_number_display',
                        'pdf_store_address_line1', 'pdf_store_address_line2',
                        'pdf_store_hours_display', 'pdf_store_locator_url_link', 'pdf_store_locator_url_text',
                        // PDF Page 3 Keys
                        'pdf_support_url_billing_link', 'pdf_support_url_billing_text', 'pdf_support_phone_main',
                        'pdf_support_url_moving_link', 'pdf_support_url_moving_text', 'pdf_support_phone_moving',
                        'pdf_faq_billing_cycle', 'pdf_faq_insufficient_funds', 'pdf_faq_disagree_charge', 'pdf_faq_service_interruption',
                        'pdf_terms_url_link', 'pdf_terms_url_text', // For Spectrum.com/policies link
                        'pdf_desc_taxes_fees', 'pdf_desc_terms_conditions', 'pdf_desc_insufficient_funds',
                        'pdf_legal_programming_changes', 'pdf_legal_recording_video', 'pdf_legal_spectrum_terms',
                        'pdf_legal_security_center', 'pdf_legal_billing_practices', 'pdf_legal_late_fee',
                        'pdf_legal_complaint_procedures', 'pdf_legal_closed_captioning',
                        'pdf_closed_caption_phone', 'pdf_closed_caption_email_addr', 'pdf_closed_caption_email_text',
                        'pdf_closed_caption_complaint_instructions_para1',
                        // PDF Header specific (if different from general site settings)
                        'security_code_placeholder', // This was in PDF template, might need to be a setting
                    ];
                    try {
                        $dbSettingsResult = Setting::whereIn('key', $settingKeys)->pluck('value', 'key')->all();
                    } catch (\Exception $e) {
                        Log::error("AppServiceProvider: Error fetching settings: " . $e->getMessage());
                    }
                } else { Log::warning("AppServiceProvider: 'settings' table not found."); }

                if (Schema::hasTable('menu_links')) {
                    try {
                        $menuDataResult['header'] = MenuLink::where('location', 'header')->orderBy('order', 'asc')->get();
                        $menuDataResult['secondary'] = MenuLink::where('location', 'secondary')->orderBy('order', 'asc')->get();
                        // $menuDataResult['footer'] = MenuLink::where('location', 'footer')->orderBy('order', 'asc')->get();
                    } catch (\Exception $e) { Log::error("AppServiceProvider: Error fetching menu links: " . $e->getMessage()); }
                } else { Log::warning('AppServiceProvider: menu_links table not found.'); }

                return ['settings' => $dbSettingsResult, 'menus' => $menuDataResult];
            });

            // Process data from cache
            $allSettingsFromCache = $sharedData['settings'] ?? [];
            $menuDataFromCache = $sharedData['menus'] ?? ['header' => collect(), 'secondary' => collect(), 'footer' => collect()];

            // Prepare siteLogoUrl (this will be used for public header and PDF logo if not overridden)
            $logoPath = $allSettingsFromCache['site_logo'] ?? null;
            $finalSiteLogoUrl = $defaultSiteLogoUrl; // Start with default
            if (!empty($logoPath) && Storage::disk('public')->exists($logoPath)) {
                $finalSiteLogoUrl = Storage::url($logoPath);
            } elseif (!empty($logoPath)) {
                Log::warning("AppServiceProvider: Site logo file '{$logoPath}' not found on public disk.");
            }

            // Prepare image URLs for settings (e.g., homepage images)
            // This adds keys like 'hp_hero_image_url' to the $allSettingsFromCache array
            $imageSettingKeys = [
                'hp_hero_image', 'hp_account_image', 'hp_internet_bg_image',
                // Add other image setting keys that store paths and need a public URL version
            ];
            foreach ($imageSettingKeys as $pathKey) {
                if (isset($allSettingsFromCache[$pathKey])) {
                    $imagePathValue = $allSettingsFromCache[$pathKey];
                    if (!empty($imagePathValue) && Storage::disk('public')->exists($imagePathValue)) {
                        $allSettingsFromCache[$pathKey . '_url'] = Storage::url($imagePathValue);
                    } else {
                        $allSettingsFromCache[$pathKey . '_url'] = null; // Ensure _url key exists
                        if (!empty($imagePathValue)) {
                            Log::warning("AppServiceProvider: Image file for setting '{$pathKey}' ('{$imagePathValue}') not found on public disk.");
                        }
                    }
                } else {
                     $allSettingsFromCache[$pathKey . '_url'] = null; // Ensure _url key exists even if base path key isn't set
                }
            }

            // Share variables with all views
            $view->with('siteLogoUrl', $finalSiteLogoUrl);       // For general site logo display
            $view->with('settings', $allSettingsFromCache);     // Contains all fetched settings, including hp_* and pdf_* and image_url versions
            $view->with('headerMenuItems', $menuDataFromCache['header']);
            $view->with('secondaryMenuItems', $menuDataFromCache['secondary']);
            // $view->with('footerMenuItems', $menuDataFromCache['footer']);
        });
    }
}
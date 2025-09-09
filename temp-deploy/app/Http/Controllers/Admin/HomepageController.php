<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Setting; // Your Setting model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Providers\AppServiceProvider; // Import AppServiceProvider for the cache key constant
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HomepageController extends Controller
{
    /**
     * Define all setting keys related to the homepage managed by this controller.
     * This helps in fetching them in the edit() method and knowing what to save.
     * Ensure all your image setting keys follow the pattern of ending with '_image' or '_bg_image'.
     */
    private array $allSettingKeys = [
        // Hero Section keys (Comment out or remove if section is permanently removed from Blade)
        // 'hp_hero_headline', 'hp_hero_subheadline', 'hp_hero_button_text', 'hp_hero_button_url', 'hp_hero_image',

        // Account Section
        'hp_account_headline', 'hp_account_subtext', 'hp_account_create_text', 'hp_account_create_url',
        'hp_account_signin_text', 'hp_account_notcustomer_text', 'hp_account_getstarted_text',
        'hp_account_getstarted_url', 'hp_account_image',

        // Internet Section
        'hp_internet_headline', 'hp_internet_subtext', 'hp_internet_button_text', 'hp_internet_button_url',
        'hp_internet_disclaimer', 'hp_internet_bg_image',

        // TODO: Add keys for other sections: Resources, Features, Careers, Solutions, News
        // Example for Resources:
        // 'hp_resources_title', 'hp_resources_description', 'hp_resources_item1_text', 'hp_resources_item1_url', 'hp_resources_item1_icon', (if icon is a text class)
        // Example for Features:
        // 'hp_features_title', 'hp_features_description', 'hp_features_main_image', 'hp_features_point1_title', 'hp_features_point1_desc',
    ];

    /**
     * Helper method to save or update a setting.
     */
    private function saveSetting(string $key, $value): void
    {
        $logValue = $value;
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            // This should not happen if called correctly, as image paths are handled before this.
            $logValue = "[UploadedFile Object - Should have been a path string: {$value->getClientOriginalName()}]";
            Log::warning("[HomepageController] saveSetting called with UploadedFile object for key: {$key}. This is unexpected.");
        } elseif (is_array($value)) {
            $logValue = json_encode($value);
        }

        Log::info("[HomepageController] Saving setting: Key='{$key}', Value='{$logValue}'");
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Helper method to handle image uploads for homepage sections.
     */
    private function handleImageUpload(Request $request, string $fileInputName, string $settingKeyForDbPath, string $errorBag, string $baseStorageDirectory = 'homepage'): string|false|null
    {
        Log::info("[HomepageController] handleImageUpload: Input='{$fileInputName}', DBKey='{$settingKeyForDbPath}', ErrorBag='{$errorBag}'");

        if ($request->boolean('remove_' . $fileInputName)) {
            $oldPath = Setting::where('key', $settingKeyForDbPath)->value('value');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
                Log::info("[HomepageController] Removed image for DB key [{$settingKeyForDbPath}] via checkbox: {$oldPath}");
            }
            return ''; // Return empty string to signify clearing the path in DB
        }

        if ($request->hasFile($fileInputName) && $request->file($fileInputName)->isValid()) {
            $file = $request->file($fileInputName);
            Log::info("[HomepageController] File '{$fileInputName}' is present and valid.");

            $oldPath = Setting::where('key', $settingKeyForDbPath)->value('value');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
                Log::info("[HomepageController] Deleted old image for DB key [{$settingKeyForDbPath}]: {$oldPath}");
            }

            try {
                $sectionSpecificDirectory = $baseStorageDirectory . '/' . Str::slug($errorBag); // e.g., homepage/account
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $safeExtension = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($extension)) ?: 'png';
                $newFilename = Str::slug($originalName) . '-' . time() . '.' . $safeExtension;
                $path = $file->storeAs($sectionSpecificDirectory, $newFilename, 'public');

                if (!$path) throw new \Exception("Storage::storeAs returned false for input: {$fileInputName}");
                Log::info("[HomepageController] Stored new image for DB key [{$settingKeyForDbPath}] at path: {$path}");
                return $path;
            } catch (\Exception $e) {
                Log::error("[HomepageController] Image upload failed for {$fileInputName}: " . $e->getMessage());
                session()->flash('error_' . $errorBag, 'Image upload failed for ' . Str::headline($fileInputName) . '.');
                return null; // Indicate upload failure
            }
        }
        Log::info("[HomepageController] No new file or removal requested for {$fileInputName}.");
        return false; // No new file, no removal request
    }

    /**
     * Show the form for editing all homepage sections.
     */
    public function edit(): View
    {
        Log::info("[HomepageController] Edit method called.");
        $dbSettings = Setting::whereIn('key', $this->allSettingKeys)->pluck('value', 'key');
        $settingsForView = [];

        foreach ($this->allSettingKeys as $key) {
            $settingValue = $dbSettings->get($key); // Use ->get() for collections
            $settingsForView[$key] = $settingValue;

            if (Str::endsWith($key, '_image') || Str::endsWith($key, '_bg_image')) {
                if (!empty($settingValue) && Storage::disk('public')->exists($settingValue)) {
                    $settingsForView[$key . '_url_preview'] = Storage::url($settingValue);
                } else {
                    $settingsForView[$key . '_url_preview'] = null;
                    if (!empty($settingValue)) {
                        Log::warning("[HomepageController] Image file not found on disk for key '{$key}': Path='{$settingValue}'");
                    }
                }
            }
        }
        // For debugging: dd($settingsForView);
        return view('admin.pages.homepage.edit', ['settings' => $settingsForView]);
    }

    // --- UPDATE METHODS FOR EACH SECTION ---

    public function updateHero(Request $request): RedirectResponse
    {
        Log::info("[HomepageController] updateHero called - section likely removed from form.");
        // If you fully remove the Hero section and its routes, delete this method.
        return redirect()->route('admin.pages.homepage.edit')->with('info_hero', 'Hero section functionality is not currently active.');
    }

    public function updateAccountSection(Request $request): RedirectResponse
    {
        $errorBag = 'account';
        Log::info("[HomepageController] updateAccountSection: Received data:", $request->all());
        $rules = [
            'hp_account_headline' => 'nullable|string|max:255',
            'hp_account_subtext' => 'nullable|string|max:1000',
            'hp_account_create_text' => 'nullable|string|max:50',
            'hp_account_create_url' => 'nullable|url|max:2048',
            'hp_account_signin_text' => 'nullable|string|max:50',
            'hp_account_notcustomer_text' => 'nullable|string|max:100',
            'hp_account_getstarted_text' => 'nullable|string|max:50',
            'hp_account_getstarted_url' => 'nullable|url|max:2048',
            'hp_account_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg,gif|max:2048',
        ];
        try {
            $validated = $request->validateWithBag($errorBag, $rules);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors(), $errorBag)->withInput();
        }

        $imagePathKeyInDb = 'hp_account_image';
        $imagePathResult = $this->handleImageUpload($request, 'hp_account_image', $imagePathKeyInDb, $errorBag, 'homepage');

        foreach ($validated as $key => $value) {
            if ($key !== 'hp_account_image') {
                $this->saveSetting($key, $value);
            }
        }
        if ($imagePathResult !== false) {
            if ($imagePathResult !== null) { $this->saveSetting($imagePathKeyInDb, $imagePathResult); }
        }

        Cache::forget(AppServiceProvider::SHARED_DATA_CACHE_KEY);
        return redirect()->route('admin.pages.homepage.edit')->with('success_' . $errorBag, 'Account section updated successfully!');
    }

    public function updateInternetSection(Request $request): RedirectResponse
    {
        $errorBag = 'internet';
        Log::info("[HomepageController] updateInternetSection: Received data:", $request->all());
        $rules = [
            'hp_internet_headline' => 'nullable|string|max:255',
            'hp_internet_subtext' => 'nullable|string|max:1000',
            'hp_internet_button_text' => 'nullable|string|max:50',
            'hp_internet_button_url' => 'nullable|url|max:2048',
            'hp_internet_disclaimer' => 'nullable|string|max:255',
            'hp_internet_bg_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg,gif|max:2048',
        ];
        try {
            $validated = $request->validateWithBag($errorBag, $rules);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors(), $errorBag)->withInput();
        }

        $imagePathKeyInDb = 'hp_internet_bg_image';
        $imagePathResult = $this->handleImageUpload($request, 'hp_internet_bg_image', $imagePathKeyInDb, $errorBag, 'homepage');

        foreach ($validated as $key => $value) {
            if ($key !== 'hp_internet_bg_image') {
                $this->saveSetting($key, $value);
            }
        }
        if ($imagePathResult !== false) {
            if ($imagePathResult !== null) { $this->saveSetting($imagePathKeyInDb, $imagePathResult); }
        }

        Cache::forget(AppServiceProvider::SHARED_DATA_CACHE_KEY);
        return redirect()->route('admin.pages.homepage.edit')->with('success_' . $errorBag, 'Internet section updated successfully!');
    }

    // Implement placeholders for other sections
    public function updateResources(Request $request): RedirectResponse {
        // TODO: Add logic for resources section
        Cache::forget(AppServiceProvider::SHARED_DATA_CACHE_KEY);
        return redirect()->route('admin.pages.homepage.edit')->with('info_resources', 'Resources section update TBD.');
    }
    public function updateFeatures(Request $request): RedirectResponse {
        // TODO: Add logic for features section
        Cache::forget(AppServiceProvider::SHARED_DATA_CACHE_KEY);
        return redirect()->route('admin.pages.homepage.edit')->with('info_features', 'Features section update TBD.');
    }
    public function updateCareers(Request $request): RedirectResponse {
        // TODO: Add logic for careers section
        Cache::forget(AppServiceProvider::SHARED_DATA_CACHE_KEY);
        return redirect()->route('admin.pages.homepage.edit')->with('info_careers', 'Careers section update TBD.');
    }
    public function updateSolutions(Request $request): RedirectResponse {
        // TODO: Add logic for solutions section
        Cache::forget(AppServiceProvider::SHARED_DATA_CACHE_KEY);
        return redirect()->route('admin.pages.homepage.edit')->with('info_solutions', 'Solutions section update TBD.');
    }
    public function updateNews(Request $request): RedirectResponse {
        // TODO: Add logic for news section
        Cache::forget(AppServiceProvider::SHARED_DATA_CACHE_KEY);
        return redirect()->route('admin.pages.homepage.edit')->with('info_news', 'News section update TBD.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
// No need for Schema here as we are not altering tables
use App\Models\Setting;              // Ensure Setting model is imported and exists
use Illuminate\Support\Facades\Cache;   // Ensure Cache facade is imported
// No need for Str here unless used for other string manipulations not shown
use App\Providers\AppServiceProvider; // <--- IMPORT AppServiceProvider to use its cache key constant

class SiteSettingsController extends Controller
{
    /**
     * Define keys managed by this General Settings form.
     * These keys should correspond to what's in your settings database table
     * and what your form fields are named.
     */
    private array $generalSettingKeys = [
        'site_name',
        'site_logo',          // Stores the relative PATH to the logo in storage/app/public
        'header_bg_color',
        'footer_text',
        // Add other general setting keys your form manages
        // 'contact_email',
        // 'default_seo_description',
    ];

    /**
     * Helper to save or update a setting in the database.
     */
    private function saveSetting(string $key, $value): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        Log::info("Setting saved/updated: Key='{$key}', Value='{$value}'");
    }

    /**
     * Handles logo upload, deletion of old logo, and returns the new storage path.
     *
     * @param Request $request The current request instance.
     * @param string $inputName The name of the file input field in the form (e.g., 'site_logo').
     * @param string $baseFilename The desired base name for the stored logo file (e.g., 'site_logo').
     * @param string $directory The directory within 'storage/app/public/' to store the logo (e.g., 'logos' or 'settings/logos').
     * @return string|false|null String path on success, null on upload failure, false if no file uploaded.
     */
    private function handleImageUpload(Request $request, string $inputName, string $baseFilename, string $directory = 'settings/logos'): string|false|null
    {
        if ($request->hasFile($inputName) && $request->file($inputName)->isValid()) {
            $file = $request->file($inputName);
            Log::info("Processing new image upload for input: {$inputName}");

            // Delete previous files with the same base name in the target directory
            $existingFiles = Storage::disk('public')->files($directory);
            foreach ($existingFiles as $existingFilePath) {
                if (pathinfo($existingFilePath, PATHINFO_FILENAME) === $baseFilename) {
                    Storage::disk('public')->delete($existingFilePath);
                    Log::info("Deleted old image file: {$existingFilePath}");
                }
            }

            // Store New File
            try {
                $extension = $file->getClientOriginalExtension();
                // Sanitize extension, default to 'png' if invalid or empty
                $safeExtension = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($extension)) ?: 'png';
                $newFilename = $baseFilename . '.' . $safeExtension;

                // storeAs returns the path relative to the disk's root (storage/app/public)
                $path = $file->storeAs($directory, $newFilename, 'public');

                if (!$path) {
                    // This case might be rare if storeAs itself doesn't throw an exception on failure,
                    // but good to have a fallback.
                    throw new \Exception("Storage::storeAs returned false or empty path for {$inputName}.");
                }
                Log::info("Stored new image file: {$path} for input {$inputName}");
                return $path; // e.g., 'settings/logos/site_logo.png'
            } catch (\Exception $e) {
                Log::error("Image upload failed for {$inputName}: " . $e->getMessage(), ['exception' => $e]);
                // Flash an error message specific to this upload failure
                session()->flash('error_upload_' . $inputName, 'Image upload failed. Please check file permissions or disk space.');
                return null; // Indicate failure
            }
        } elseif ($request->boolean('remove_' . $inputName)) {
            // Handle checkbox for removing the image
            $currentPath = Setting::where('key', $inputName)->value('value'); // Assuming setting key matches input name
            if ($currentPath && Storage::disk('public')->exists($currentPath)) {
                Storage::disk('public')->delete($currentPath);
                Log::info("Removed image via checkbox: {$currentPath} for input {$inputName}");
            }
            return ''; // Return empty string to signify removal, which will update the DB setting to null/empty
        }

        return false; // Indicate no new file was uploaded and no removal was requested
    }

    /**
     * Show the form for editing general site settings.
     */
    public function editGeneral(): View
    {
        // Fetch all settings defined in $generalSettingKeys
        $dbSettings = Setting::whereIn('key', $this->generalSettingKeys)->pluck('value', 'key')->all();
        $settings = [];
        foreach ($this->generalSettingKeys as $key) {
            $settings[$key] = $dbSettings[$key] ?? null; // Ensure all keys exist, even if null
        }

        // The 'site_logo' key in $settings contains the PATH from the database.
        // The AppServiceProvider's view composer will convert this path to a public URL ($siteLogoUrl)
        // for display in the header. For the settings form, you might also want to display the current logo.
        if (!empty($settings['site_logo']) && Storage::disk('public')->exists($settings['site_logo'])) {
            $settings['site_logo_url_preview'] = Storage::url($settings['site_logo']);
        } else {
            $settings['site_logo_url_preview'] = null;
        }

        return view('admin.settings.edit-general', compact('settings'));
    }

    /**
     * Update general site settings in storage.
     */
    public function updateGeneral(Request $request): RedirectResponse
    {
        // Define an error bag for this specific form if you have multiple settings forms
        $errorBag = 'updateGeneralSettings';

        $validatedData = $request->validateWithBag($errorBag, [
            'site_name' => 'nullable|string|max:191',
            'site_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,svg,webp', 'max:2048'], // Max 2MB
            'header_bg_color' => ['nullable', 'string', 'regex:/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/i'], // Case-insensitive hex
            'footer_text' => 'nullable|string|max:5000',
            // Add validation for other keys in $this->generalSettingKeys
            // 'contact_email' => 'nullable|email|max:191',
            // 'default_seo_description' => 'nullable|string|max:300',
        ]);

        try {
            // Handle Logo Upload
            // The input name in the form is 'site_logo'
            // The base filename for the stored image will be 'site_logo' (e.g., site_logo.png)
            // The setting key in the database to store the path is also 'site_logo'
            $logoPathResult = $this->handleImageUpload($request, 'site_logo', 'site_logo', 'settings/logos');

            if ($logoPathResult !== false) { // If true (path string) or null (upload error) or empty string (removal)
                if ($logoPathResult === null) { // Explicit upload failure
                    // Error message already flashed by handleImageUpload
                    // We might choose to not save other settings if logo upload is critical and failed.
                    // For now, let's proceed but the error will be shown.
                } else { // Path string (success) or empty string (removal via checkbox)
                    $this->saveSetting('site_logo', $logoPathResult); // Save new path or empty string
                }
            }
            // If $logoPathResult is false, no new file was uploaded, and no removal requested, so do nothing to 'site_logo' setting.

            // Handle other settings using $validatedData to ensure only validated data is used
            foreach ($this->generalSettingKeys as $key) {
                if ($key === 'site_logo') continue; // Already handled

                if ($request->has($key)) { // Check if the field was submitted (even if empty)
                    $this->saveSetting($key, $validatedData[$key] ?? null);
                }
            }

            // --- CRITICAL: Clear the correct cache ---
            Cache::forget(AppServiceProvider::SHARED_DATA_CACHE_KEY);
            Log::info('SiteSettingsController: Manually cleared cache for key: ' . AppServiceProvider::SHARED_DATA_CACHE_KEY);

            return redirect()->route('admin.settings.general.edit')
                             ->with('status', 'General settings updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors are automatically handled by Laravel, redirecting back with errors.
            // This catch block is more for other unexpected exceptions during the process.
            Log::error("Validation exception during general settings update: ", $e->errors());
            return back()->withErrors($e->errors(), $errorBag)->withInput(); // Redirect back with specific bag
        } catch (\Exception $e) {
            Log::error("Error updating general site settings: " . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'An unexpected error occurred while updating settings. Please check the logs.')->withInput();
        }
    }
}
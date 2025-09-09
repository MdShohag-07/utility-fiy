<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
// Example using a hypothetical Setting model
// use App\Models\Setting;

class FooterController extends Controller
{
    /**
     * Show the form for editing footer information.
     */
    public function edit(): View
    {
        // --- Load Footer Settings ---
        // Replace this with your actual logic to load settings
        // Example using a hypothetical Setting model:
        // $settings = Setting::whereIn('key', [
        //     'footer_copyright', 'footer_col1_links_json', 'footer_col2_links_json',
        //     'footer_social_links_json', 'footer_bottom_links_json'
        // ])->pluck('value', 'key');

        // Placeholder data structure if not loading from DB:
        $settings = collect([
            'footer_copyright' => '© ' . date('Y') . ' ' . config('app.name', 'Utility Site') . '. All Rights Reserved.',
            'footer_col1_links_json' => json_encode([ ['title' => 'Newsroom', 'url' => '#'], ['title' => 'Gov Relations', 'url' => '#'], ['title' => 'Business With Us', 'url' => '#'], ['title' => 'Careers', 'url' => '#'], ['title' => 'Contact Us', 'url' => '#'], ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'footer_col2_links_json' => json_encode([ ['title' => 'Privacy Policy', 'url' => '#'], ['title' => 'Terms of Use', 'url' => '#'], ['title' => 'Accessibility', 'url' => '#'], ['title' => 'Site Map', 'url' => '#'], ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'footer_social_links_json' => json_encode([ ['platform' => 'facebook', 'url' => '#', 'icon' => 'fab fa-facebook-f'], ['platform' => 'twitter', 'url' => '#', 'icon' => 'fab fa-twitter'], ['platform' => 'instagram', 'url' => '#', 'icon' => 'fab fa-instagram'], ['platform' => 'linkedin', 'url' => '#', 'icon' => 'fab fa-linkedin-in'], ['platform' => 'youtube', 'url' => '#', 'icon' => 'fab fa-youtube'], ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'footer_bottom_links_json' => json_encode([ ['title' => 'Terms of Use', 'url' => '#'], ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ]);
        // --- End Loading ---

        return view('admin.footer.edit', compact('settings'));
    }

    /**
     * Update the footer information in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        // --- Validation ---
        // Validate main text field + ensure link fields contain valid JSON arrays
        $validated = $request->validate([
            'footer_copyright' => 'nullable|string|max:500',
            'footer_col1_links_json' => ['nullable', 'json', function ($attribute, $value, $fail) { if (!is_null($value) && !is_array(json_decode($value, true))) { $fail($attribute.' must be a valid JSON array.'); } }],
            'footer_col2_links_json' => ['nullable', 'json', function ($attribute, $value, $fail) { if (!is_null($value) && !is_array(json_decode($value, true))) { $fail($attribute.' must be a valid JSON array.'); } }],
            'footer_social_links_json' => ['nullable', 'json', function ($attribute, $value, $fail) { if (!is_null($value) && !is_array(json_decode($value, true))) { $fail($attribute.' must be a valid JSON array.'); } }],
            'footer_bottom_links_json' => ['nullable', 'json', function ($attribute, $value, $fail) { if (!is_null($value) && !is_array(json_decode($value, true))) { $fail($attribute.' must be a valid JSON array.'); } }],
        ]);

        try {
            // --- Save the updated footer information ---
            // Loop through validated data and update/create settings
            foreach ($validated as $key => $value) {
                // Replace with your actual saving logic (e.g., Setting model)
                // Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
                Log::info("Updating Footer Setting: $key"); // Example Log
            }

        } catch (\Exception $e) {
            Log::error("Error updating footer settings: " . $e->getMessage());
            return back()->with('error', 'Error updating footer settings. Please check logs and JSON format.')->withInput();
        }

        return redirect()->route('admin.footer.edit')->with('status', 'Footer information updated successfully!');
    }
}
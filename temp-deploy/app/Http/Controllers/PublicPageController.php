<?php
// app/Http/Controllers/PublicPageController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Setting; // Import Setting model
use Illuminate\Support\Facades\Storage; // Import Storage facade
use Illuminate\Support\Facades\Cache; // Optional
use Illuminate\Support\Facades\Log; // For debugging

class PublicPageController extends Controller
{
    public function home(): View
    {
        // Define keys needed for homepage - CORRECTED KEYS
        $keys = [
             'hp_hero_headline', 'hp_hero_subheadline', 'hp_hero_button_text', 'hp_hero_button_url', 'hp_hero_image',
             'hp_res1_icon', 'hp_res1_title', 'hp_res1_text', 'hp_res1_btn_text', 'hp_res1_btn_url',
             'hp_res2_icon', 'hp_res2_title', 'hp_res2_text', 'hp_res2_btn_text', 'hp_res2_btn_url',
             'hp_res3_icon', 'hp_res3_title', 'hp_res3_text', 'hp_res3_btn_text', 'hp_res3_btn_url',
             'hp_feat1_image', 'hp_feat1_title', 'hp_feat1_text', 'hp_feat1_btn_text', 'hp_feat1_btn_url',
             'hp_feat2_image', 'hp_feat2_title', 'hp_feat2_text', 'hp_feat2_btn_text', 'hp_feat2_btn_url',
             // Corrected career keys
             'hp_careers_image', 'hp_careers_title', 'hp_careers_btn_text', 'hp_careers_btn_url',
             'hp_sol1_image','hp_sol1_title','hp_sol1_text','hp_sol1_btn_text','hp_sol1_btn_url',
             'hp_sol2_image','hp_sol2_title','hp_sol2_text','hp_sol2_btn_text','hp_sol2_btn_url',
             'hp_sol3_image','hp_sol3_title','hp_sol3_text','hp_sol3_btn_text','hp_sol3_btn_url',
             // News button keys are included here
             'hp_news1_image','hp_news1_title','hp_news1_text','hp_news1_btn_text','hp_news1_btn_url',
             'hp_news2_image','hp_news2_title','hp_news2_text','hp_news2_btn_text','hp_news2_btn_url',
        ];

        // Fetch settings (Consider caching later)
        // Get settings from DB where 'key' is one of the listed $keys
        // Result is an associative array: ['setting_key' => 'setting_value', ...]
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key')->all();

        // Add image URLs if paths exist
        $imageKeys = [
            'hp_hero_image', 'hp_feat1_image', 'hp_feat2_image',
            'hp_careers_image', // Corrected key
            'hp_sol1_image', 'hp_sol2_image', 'hp_sol3_image',
            // News image keys are included here
            'hp_news1_image', 'hp_news2_image'
         ];

         foreach ($imageKeys as $key) {
             $imagePath = $settings[$key] ?? null;
             // Use the 'public' disk configuration to check existence and get URL
             if (!empty($imagePath) && Storage::disk('public')->exists($imagePath)) {
                 $settings[$key.'_url'] = Storage::url($imagePath); // Add _url key
             } else {
                  $settings[$key.'_url'] = null; // Set to null if image doesn't exist
                  if (!empty($imagePath)) {
                      Log::warning("Homepage image file not found on public disk: " . $imagePath . " (Key: " . $key . ")");
                  }
             }
         }

        // --- DEBUGGING STEP ---
        // Uncomment the next line temporarily to see exactly what data is passed to the view
        // dd($settings);
        // --- END DEBUGGING STEP ---


        // Ensure this view path is correct: resources/views/public/home.blade.php
        return view('public.home', compact('settings'));
    }

    public function forgotUsername(): View { return view('auth.forgot-username'); }
}
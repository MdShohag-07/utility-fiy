<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuLink;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Providers\AppServiceProvider; // Import AppServiceProvider to use the cache key constant

class MenuLinkController extends Controller
{
    // This should match the constant in AppServiceProvider
    // Used for clearing the cache when menu items are changed
    private string $sharedDataCacheKey = AppServiceProvider::SHARED_DATA_CACHE_KEY;

    /**
     * Define validation rules for storing/updating menu links.
     */
    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:2048',
            'target' => 'required|string|in:_self,_blank',
            'location' => 'required|string|max:50', // Ensure these locations match your system
            'order' => 'required|integer|min:0',
            'icon' => 'nullable|string|max:100', // For Font Awesome class etc.
        ];
    }

    /**
     * Display a listing of the menu links.
     */
    public function index(): View
    {
        // Fetch all menu links, ordered by location and then by their display order
        $menuLinks = MenuLink::orderBy('location', 'asc')
                           ->orderBy('order', 'asc')
                           ->get();

        Log::info("MenuLinkController@index: Fetched " . $menuLinks->count() . " menu links.");

        // Pass the fetched menu links to the view
        return view('admin.menus.index', compact('menuLinks'));
    }

    /**
     * Show the form for creating a new menu link.
     */
    public function create(): View
    {
        // Define available menu locations for the form dropdown
        $locations = [
            'header' => 'Public Homepage Sidebar (Main Nav)', // For new homepage sidebar
            'secondary' => 'Public Header - Secondary Nav',
            'footer' => 'Public Footer Nav', // Example, if you have footer menus
            // 'user_dashboard' => 'User Dashboard Sidebar', // If you make user dashboard sidebar dynamic
        ];
        return view('admin.menus.create', compact('locations'));
    }

    /**
     * Store a newly created menu link in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        MenuLink::create($validated);

        Log::info("MenuLinkController@store: Attempting to clear cache key: " . $this->sharedDataCacheKey);
        Cache::forget($this->sharedDataCacheKey);
        Log::info("MenuLinkController@store: Cache key '{$this->sharedDataCacheKey}' forget called after creating menu link.");

        return redirect()->route('admin.menus.index')
                         ->with('status', 'Menu link created successfully!');
    }

    /**
     * Show the form for editing the specified menu link.
     */
    public function edit(MenuLink $menuLink): View // Route Model Binding
    {
        // Define available menu locations for the form dropdown
        $locations = [
            'header' => 'Public Homepage Sidebar (Main Nav)',
            'secondary' => 'Public Header - Secondary Nav',
            'footer' => 'Public Footer Nav',
            // 'user_dashboard' => 'User Dashboard Sidebar',
        ];
        return view('admin.menus.edit', compact('menuLink', 'locations'));
    }

    /**
     * Update the specified menu link in storage.
     */
    public function update(Request $request, MenuLink $menuLink): RedirectResponse // Route Model Binding
    {
        $validated = $request->validate($this->rules());
        $menuLink->update($validated);

        Log::info("MenuLinkController@update: Attempting to clear cache key: " . $this->sharedDataCacheKey);
        Cache::forget($this->sharedDataCacheKey);
        Log::info("MenuLinkController@update: Cache key '{$this->sharedDataCacheKey}' forget called after updating menu link.");

        return redirect()->route('admin.menus.index')
                         ->with('status', 'Menu link updated successfully!');
    }

    /**
     * Remove the specified menu link from storage.
     */
    public function destroy(MenuLink $menuLink): RedirectResponse // Route Model Binding
    {
        $title = $menuLink->title;
        $menuLink->delete();

        Log::info("MenuLinkController@destroy: Attempting to clear cache key: " . $this->sharedDataCacheKey);
        Cache::forget($this->sharedDataCacheKey);
        Log::info("MenuLinkController@destroy: Cache key '{$this->sharedDataCacheKey}' forget called after deleting menu link '{$title}'.");

        return redirect()->route('admin.menus.index')
                         ->with('status', "Menu link '{$title}' deleted successfully!");
    }
}
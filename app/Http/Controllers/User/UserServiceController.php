<?php
// app/Http/Controllers/User/UserServiceController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserServiceController extends Controller
{
    /**
     * Display the user's services overview page.
     */
    public function index(): View
    {
        $user = Auth::user();

        // --- Placeholder Data (Replace with actual logic) ---
        $servicesData = [
            'internet' => [
                'active' => true, // Flag to show this tab content initially
                'connectionStatus' => 'Your internet is connected.',
                'planName' => 'Internet Gig',
                'planDetails' => 'with speeds up to 1000 Mbps',
                'planDetailsUrl' => '#',
                'modemStatus' => 'Connected',
                'modemUrl' => '#',
                'wifiNetworksCount' => 0,
                'addEquipmentUrl' => '#',
                'exploreLinks' => [
                    ['url' => '#', 'text' => 'Upgrade Internet Plan', 'subtext' => 'Get more speed for streaming, browsing and gaming.'],
                    ['url' => '#', 'text' => 'Download Security Suite', 'subtext' => 'Get online protection at no additional cost.'],
                    ['url' => '#', 'text' => 'Activate Equipment', 'subtext' => 'Set up all your devices for the best experience.'],
                ],
                'supportLinks' => [
                    ['url' => '#', 'text' => 'Troubleshoot Common Internet Issues'],
                    ['url' => '#', 'text' => 'Reboot Your Internet Modem'],
                    ['url' => '#', 'text' => 'Maximizing Your WiFi Speeds'],
                    ['url' => '#', 'text' => 'Tips to Improve Your Wireless Security'],
                    ['url' => '#', 'text' => 'See All Internet Support'],
                ],
            ],
            'tv' => [
                'active' => false,
                // Add placeholder data for TV service details
                'planName' => 'Spectrum TV Select',
                'channels' => '125+ Channels',
                'equipment' => [
                    ['name' => 'Living Room Box', 'status' => 'Active'],
                ],
                 'exploreLinks' => [ /* ... TV related explore links ... */ ],
                 'supportLinks' => [ /* ... TV related support links ... */ ],
            ],
            'mobile' => [
                'active' => false,
                'planName' => 'Unlimited Mobile',
                 'lines' => [ /* ... details about mobile lines ... */],
                 'exploreLinks' => [ /* ... Mobile related explore links ... */ ],
                 'supportLinks' => [ /* ... Mobile related support links ... */ ],
            ],
            'phone' => [
                 'active' => false,
                 'planName' => 'Home Phone',
                 'features' => [/* ... phone features ... */],
                 'exploreLinks' => [ /* ... Phone related explore links ... */ ],
                 'supportLinks' => [ /* ... Phone related support links ... */ ],
            ],
        ];
        // --- End Placeholder Data ---

        // Ensure view exists: resources/views/user/services/index.blade.php
        return view('user.services.index', compact('user', 'servicesData'));
    }
}
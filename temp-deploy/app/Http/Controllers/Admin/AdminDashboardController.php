<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import User model

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetch basic stats (implement real logic later)
        $userCount = User::count();
        $statementCount = 0; // Placeholder
        $menuLinkCount = 0; // Placeholder
        $pageTitle = "Dashboard";

        return view('admin.dashboard', compact(
            'pageTitle',
            'userCount',
            'statementCount',
            'menuLinkCount'
        ));
    }
}
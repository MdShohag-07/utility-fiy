<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch data for the homepage later if needed
        $pageTitle = "Your Utility Company";
        return view('public.index', compact('pageTitle'));
    }
}
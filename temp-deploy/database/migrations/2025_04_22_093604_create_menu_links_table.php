<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the 'menu_links' table to store header/footer navigation items.
     */
    public function up(): void
    {
        Schema::create('menu_links', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key 'id'
            $table->string('title'); // Text displayed for the link (e.g., "Home", "Contact Us")
            $table->string('url'); // The URL the link points to (e.g., "/", "/contact", "https://example.com")
            $table->string('target')->default('_self'); // How the link opens: _self (same window), _blank (new tab)
            $table->integer('order')->default(0); // Integer for sorting menu items
            $table->string('location')->default('header'); // Add location ('header', 'footer', 'secondary_nav')
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     * Drops the 'menu_links' table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_links');
    }
};
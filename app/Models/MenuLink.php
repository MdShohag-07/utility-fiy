<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    use HasFactory;
    protected $table = 'menu_links'; // Verify your table name

    protected $fillable = [
        'title',
        'url',
        'target',
        'order',
        'location',
        'icon', // *** ADDED: For Font Awesome icon class ***
    ];

    protected $casts = [ 'order' => 'integer', ];

    protected $attributes = [
         'order' => 0,
         'target' => '_self',
         'location' => 'header', // Default location
         'icon' => null,        // Default icon to null
     ];

    // Keep user relationship if you have it
    // public function user() { return $this->belongsTo(User::class); }
}
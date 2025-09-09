<?php
// app/Models/Setting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory; // Optional: If you use factories

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // *** THIS IS CRUCIAL - ADD OR ENSURE IT EXISTS ***
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * The table associated with the model.
     * Set this if your table name is NOT 'settings'.
     *
     * @var string
     */
    // protected $table = 'your_settings_table_name'; // Uncomment and change if needed

    /**
     * Indicates if the model should be timestamped.
     * Set to false if your 'settings' table doesn't have created_at/updated_at columns.
     *
     * @var bool
     */
    // public $timestamps = false; // Uncomment if needed

    /**
     * The primary key associated with the table.
     * Often 'key' is used as the primary key for settings tables.
     * updateOrCreate works best if 'key' is unique or primary.
     *
     * @var string
     */
     // protected $primaryKey = 'key'; // Uncomment if 'key' is your primary key AND is not 'id'
     // public $incrementing = false; // Add this if primary key is not auto-incrementing (like 'key')
     // protected $keyType = 'string'; // Add this if primary key 'key' is a string
}
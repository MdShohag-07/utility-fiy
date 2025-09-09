<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatementItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'statement_id',
        'description',
        'quantity',
        'unit_price',
        'amount', // This should be calculated (quantity * unit_price)
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function statement(): BelongsTo
    {
        return $this->belongsTo(Statement::class); // <--- THIS RELATIONSHIP
    }
}
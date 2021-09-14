<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FishingLicence extends Model
{
    use HasFactory;

    protected $table = 'fishing_licence';

    protected $fillable = [
        'user_id',
        'address',
        'number_of_rods',
        'number_of_fishing_hooks',
        'valid_from',
        'valid_to',
        'region',
        'status',
        'price'

    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'id');
    }
}

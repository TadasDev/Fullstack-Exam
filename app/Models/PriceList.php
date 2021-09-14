<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    use HasFactory;

    protected $table='price_list';

    protected $fillable = [
        'price_per_day',
        'price_per_rod',
        'price_per_fishing_hook',
    ];
}

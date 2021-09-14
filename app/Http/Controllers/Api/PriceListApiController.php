<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PriceList;

class PriceListApiController extends Controller
{
    public function priceList()
    {
        return   PriceList::all();

    }
}

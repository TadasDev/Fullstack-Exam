<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Region;


class RegionApiController extends Controller
{
    public function listOfRegions()
    {
        return   Region::all();

    }
}

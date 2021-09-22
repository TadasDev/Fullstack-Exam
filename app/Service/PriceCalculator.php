<?php

namespace App\Service;

use App\Models\PriceList;
use Illuminate\Support\Carbon;

class PriceCalculator
{
        public function CalculatePrice($request )
        {

            $to_date = Carbon::parse($request->valid_from);
            $from_date = Carbon::parse($request->valid_to);
            $total_days = $to_date->diffInDays($from_date);

            $pricePerDay = PriceList::all()->pluck('price_per_day')->first(); // price 10
            $pricePerRod = PriceList::all()->pluck('price_per_rod')->first();// price 2
            $pricePerHook = PriceList::all()->pluck('price_per_fishing_hook')->first();// price 1

            $numberOfRods = $request->number_of_rods;
            $numberOfHooks = $request->number_of_fishing_hooks;

            $price = ($total_days * $pricePerDay) + ($numberOfRods * $pricePerRod) + ($numberOfHooks * $pricePerHook);

            return $price;
        }
}

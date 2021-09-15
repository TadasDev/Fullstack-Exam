<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LicenceResource;
use App\Models\FishingLicence;
use App\Models\PriceList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FishingLicenceApiController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $licences = FishingLicence::all()->sortBy('valid_to')->where('user_id', Auth::id())->take(30);

        return LicenceResource::collection($licences);
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),
            [
                'address' => 'required|max:255',
                'number_of_rods' => 'required|max:10',
                'number_of_fishing_hooks' => 'required|max:50',
                'valid_from' => 'required|date',
                'valid_to' => 'required|date',
                'region' => 'required',
            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
//   Calculation for the price
        $to_date = Carbon::parse($request->valid_from);
        $from_date = Carbon::parse($request->valid_to);
        $total_days = $to_date->diffInDays($from_date);

        $pricePerDay = PriceList::all()->pluck('price_per_day')->first(); // price 10
        $pricePerRod = PriceList::all()->pluck('price_per_rod')->first();// price 2
        $pricePerHook = PriceList::all()->pluck('price_per_fishing_hook')->first();// price 1

        $numberOfRods = $request->number_of_rods;
        $numberOfHooks = $request->number_of_fishing_hooks;

        $price = ($total_days * $pricePerDay) + ($numberOfRods * $pricePerRod) + ($numberOfHooks * $pricePerHook);

        FishingLicence::create([
            'user_id' => \auth()->id(),
            'address' => $request->address,
            'number_of_rods' => $request->number_of_rods,
            'number_of_fishing_hooks' => $request->number_of_fishing_hooks,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'region' => $request->region,
            'status' => 1,
            'price' => $price
        ]);
        return response()->json(['status' => 'success']);

    }

}

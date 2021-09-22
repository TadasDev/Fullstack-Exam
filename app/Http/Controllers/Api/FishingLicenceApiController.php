<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LicenceResource;
use App\Models\FishingLicence;
use App\Service\PriceCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FishingLicenceApiController extends Controller
{
    public $priceCalculator;

    public function __construct(
        PriceCalculator $priceCalculator
    )
    {
        $this->priceCalculator = $priceCalculator;
    }


    public function index(): AnonymousResourceCollection
    {
        $licences = FishingLicence::all()->sortBy('valid_to')
            ->where('user_id', Auth::id())
            ->take(30);

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
        FishingLicence::create([
            'user_id' => \auth()->id(),
            'address' => $request->address,
            'number_of_rods' => $request->number_of_rods,
            'number_of_fishing_hooks' => $request->number_of_fishing_hooks,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'region' => $request->region,
            'status' => 1,
            'price' => $this->priceCalculator->CalculatePrice($request)
        ]);
        return response()->json(['status' => 'success']);

    }

}

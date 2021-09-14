<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LicenceResource extends JsonResource
{
    public function toArray($request):array
    {
        return [
            'id'=>$this->id,
            'address'=>$this->address,
            'number_of_rods'=>$this->number_of_rods,
            'number_of_fishing_hooks'=>$this->number_of_fishing_hooks,
            'valid_from'=>$this->valid_from,
            'valid_to'=>$this->valid_to,
            'region'=>$this->region,
            'status'=>$this->status,
            'price'=>$this->price

        ];
    }


}


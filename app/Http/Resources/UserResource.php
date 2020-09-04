<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'shopId' => $this->shop_id,
            'shopName' => $this->shop->name,
            'shopCover' => url('/storage').'/'.$this->shop->cover,
            'shopLogo' => url('/storage').'/'.$this->shop->logo,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RandomUserResources extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            $this->mergeWhen($this->resource->name, [
                'full_name' => $this->resource->name['first'] . ' ' . $this->resource->name['last'],
            ]),
            'country' => $this->whenHas('location', $this->location['country']),
            'phone' => $this->whenHas('phone'),
            'email' => $this->whenHas('email'),
            'gender' => $this->whenHas('gender'),
            'name' => $this->whenHas('name'),
            'location' => $this->whenHas('location'),
            'login' => $this->whenHas('login'),
            'registered' => $this->whenHas('registered'),
            'dob' => $this->whenHas('dob'),
            'cell' => $this->whenHas('cell'),
            'id' => $this->whenHas('id'),
            'picture' => $this->whenHas('picture'),
            'nat' => $this->whenHas('nat'),
        ];
    }


}

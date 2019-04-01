<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'id'               => $this->id,
            'name'             => $this->name,
            'surname'          => $this->surname,
            'company'          => $this->company,
            'telephone'        => $this->telephone,
            'email'            => $this->email,
            'orders_sum'       => $this->orders_sum,
            'source_id'        => $this->source_id,
            'delivery'         => $this->delivery,
            'rate_value'       => $this->rate_value,
            'rate_description' => $this->rate_description,
        ];
    }
}

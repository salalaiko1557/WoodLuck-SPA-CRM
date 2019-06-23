<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'             => $this->id,
            'customer_id'    => $this->customer_id,
            'order_type_id'  => $this->order_type_id,
            'price'          => $this->price,
            'pay_type_id'    => $this->pay_type_id,
            'description'    => $this->description,
            'text_execution' => $this->text_execution,
            'date_execution' => $this->date_execution,
            'material_id'    => $this->material_id,
            'material_count' => $this->material_count,
            'canban_status'  => $this->canban_status,
            'canban_column'  => $this->canban_column,
            'draw'           => $this->draw,
            'mires_id'       => $this->mires_id,
            'delivery_adress'=> $this->delivery_adress,
            'order_number'   => $this->order_number,
            'deadline_date'  => $this->deadline_date,
        ];
    }
}

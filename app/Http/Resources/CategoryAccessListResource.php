<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryAccessListResource extends JsonResource
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
            "id" => $this->id,
            "create" => $this->create,
            "read" => $this->read,
            "update" => $this->update,
            "category" => CategoryResource::make($this->category)
        ];
    }
}

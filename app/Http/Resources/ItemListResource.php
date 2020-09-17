<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemListResource extends JsonResource
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
            'serial' => $this->serial,
            'model' => $this->model,
            'producer' => $this->producer,
            'person_id' => $this->person->id,
            'inside_identifier' => $this->inside_identifier,
            'localization_id' => $this->localization->id,
            'sub_localization_id' => $this->subLocalization->id,
            'item_category_id' => ItemCategoryResource::collection($this->itemCategory)
        ];
    }
}

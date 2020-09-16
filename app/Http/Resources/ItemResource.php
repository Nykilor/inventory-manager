<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'person' => PersonResource::make($this->person),
            'inside_identifier' => $this->inside_identifier,
            'localization' => LocalizationResource::make($this->localization),
            'sub_localization' => SubLocalizationResource::make($this->subLocalization),
            'item_category' => ItemCategoryResource::collection($this->itemCategory)
        ];
    }
}

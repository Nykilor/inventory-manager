<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemShowResurce extends JsonResource
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
            'item_category' => ItemCategoryResource::collection($this->itemCategory),
            'item_person_change_history' => ItemPersonChangeHistoryResource::collection($this->itemPersonChangeHistory),
            'disposed_by_person_id' => PersonResource::make($this->disposedBy),
            'is_disposed' => $this->is_disposed
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPersonChangeHistory extends Model
{
    use HasFactory;

    protected $table = 'item_person_change_history';

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function person()
    {
        return $this->belongsTo('App\Models\Person', 'new_person_id');
    }
}

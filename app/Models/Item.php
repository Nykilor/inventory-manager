<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';

    public function itemPersonChangeHistory()
    {
        return $this->hasMany('App\Models\ItemPersonChangeHistory');
    }

    public function itemCategory()
    {
        return $this->hasMany('App\Models\ItemCategory');
    }

    public function person()
    {
        return $this->belongsTo('App\Models\Person');
    }

    public function localization()
    {
        return $this->belongsTo('App\Models\Localization');
    }
}

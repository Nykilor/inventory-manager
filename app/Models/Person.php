<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';

    public function itemPersonChangeHistory()
    {
        return $this->hasMany('App\Models\ItemPersonChangeHistory');
    }

    public function item()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id');
    }
}

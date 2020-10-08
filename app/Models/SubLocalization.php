<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLocalization extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'sub_localization';

    public function localization()
    {
        return $this->belongsTo('App\Models\Localization');
    }

    public function item()
    {
        return $this->hasMany('App\Models\Item');
    }
}

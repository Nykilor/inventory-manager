<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLocalization extends Model
{
    use HasFactory;

    protected $table = 'sub_localization';

    public function localization()
    {
        $this->belongsTo('App\Models\Localization');
    }

    public function item()
    {
        $this->hasMany('App\Models\Item');
    }
}

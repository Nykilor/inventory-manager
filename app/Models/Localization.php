<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localization extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'localization';

    public function item()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function subLocalization()
    {
        return $this->hasMany('App\Models\SubLocalization');
    }
}

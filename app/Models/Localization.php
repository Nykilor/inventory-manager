<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localization extends Model
{
    use HasFactory;

    protected $table = 'localization';

    public function item()
    {
        $this->hasMany('App\Models\Item');
    }

    public function subLocalization()
    {
        $this->hasMany('App\Models\SubLocalization');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLocalization extends Model
{
    use HasFactory;

    public function localization()
    {
        $this->belongsTo('App\Models\Localization');
    }
}

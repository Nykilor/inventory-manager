<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $table = 'item_category';

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}

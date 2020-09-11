<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    public function itemCategory()
    {
        return $this->hasMany('App\Models\ItemCategory');
    }

    public function categoryAccess()
    {
        return $this->hasMany('App\Models\CategoryAccess');
    }
}

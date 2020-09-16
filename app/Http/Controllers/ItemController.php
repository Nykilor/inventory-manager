<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\CategoryAccess;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('read');
        $items = Item::with([
            'person',
            'localization',
            'subLocalization',
            'itemCategory'
        ])->whereHas('itemCategory', function($query) use($user_category_access) {
            $query->whereIn('id', $user_category_access);
        })->get();

        return ItemResource::collection($items);
    }
}

<?php

namespace App\Http\Controllers;

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
        $access_restriction = CategoryAccess::with('category')->where('users_id', '=', $user->id)->get();
        $user_accessible_categories = [];
        foreach ($access_restriction as $category) {
            $user_accessible_categories[] = $category->category->name;
        }
        $items = Item::with('itemCategory')->get();

        foreach($items as $item) {
            var_dump($item);
        }
    }
}

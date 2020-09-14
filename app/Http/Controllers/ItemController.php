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
        var_dump($user);
        exit(); //todo add so that category names that the user can read are in Auth:user object
        $access_restriction = CategoryAccess::with('category')->where('users_id', '=', $user->id)->get();
        $user_accessible_categories = [];
        foreach ($access_restriction as $category) {
            $user_accessible_categories[] = $category->category->name;
        }
        $items = Item::with(['itemCategory', 'person'])->get();

        return ItemResource::collection($items);
    }
}

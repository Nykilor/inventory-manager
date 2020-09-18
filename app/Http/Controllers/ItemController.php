<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemListResource;
use App\Http\Resources\ItemShowResurce;
use App\Models\Category;
use App\Models\CategoryAccess;
use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('read');
        $items = Item::with([
            'person',
            'localization',
            'subLocalization',
        ])->whereHas('itemCategory', function($query) use($user_category_access)
        {
            $this->addUserFilteringToDataFetch($query, 'item_category_id', 'whereIn', ['category_id']);
            $query->whereIn('category_id', $user_category_access);
        });
        //TODO repository pattern
        //Handle all the non-array user filtering queries
        $this->addUserFilteringToDataFetch($items, 'person_id', 'where', ['id', '=']);
        $this->addUserFilteringToDataFetch($items, 'localization_id', 'where', ['id', '=']);
        $this->addUserFilteringToDataFetch($items, 'sub_localization_id', 'where', ['id', '=']);
        $this->addUserFilteringToDataFetch($items, 'model', 'where', ['model', 'LIKE']);
        $this->addUserFilteringToDataFetch($items, 'serial', 'where', ['serial', 'LIKE']);
        $this->addUserFilteringToDataFetch($items, 'producer', 'where', ['producer', 'LIKE']);
        $this->addUserFilteringToDataFetch($items, 'inside_identifier', 'where', ['inside_identifier', 'LIKE']);

        return ItemListResource::collection($items->get());
    }

    public function show($id)
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('read');

        $item = Item::with([
            'person',
            'localization',
            'subLocalization',
        ])->whereHas('itemCategory', function($query) use($user_category_access) {
            $query->whereIn('id', $user_category_access);
        })->where('id', '=', $id)->firstOrFail();

        return ItemShowResurce::make($item);
    }

    /**
     * Calls a given method ($func) on $builder with user data given in url query parameter with the spread of given array of $parameters
     * @param Builder $builder
     * @param string $user_query $_GET key
     * @param string $func f.i where, whereIn etc
     * @param array $parameters f.i ['id', '='], ['category_id']
     */
    protected function addUserFilteringToDataFetch(Builder &$builder, string $user_query, string $func, array $parameters)
    {
        $request = $this->request;

        if($user_query_value = $request->query($user_query))
        {
            if(strpos($user_query_value, '[') === 0 && strpos($user_query_value, ']') > 1)
            {
                $parameters[] = array_filter(explode(',', str_replace(['[',']'], "", $user_query_value)));
            }
            else
            {
                $parameters[] = $user_query_value;
            }

            $builder->$func(...$parameters);
        }
    }
}

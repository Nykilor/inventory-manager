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
    public function index(Request $request)
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('read');
        $items = Item::with([
            'person',
            'localization',
            'subLocalization',
            'itemCategory'
        ])->whereHas('itemCategory', function($query) use($user_category_access, $request)
        {
            $query->whereIn('id', $user_category_access);
        });
        //TODO repository pattern
        //Handle all the non-array user filtering queries
        $this->addWhereToFetchBasedOnUserByIdQuery($items, $request, 'person_id', ['id', '=']);
        $this->addWhereToFetchBasedOnUserByIdQuery($items, $request, 'localization_id', ['id', '=']);
        $this->addWhereToFetchBasedOnUserByIdQuery($items, $request, 'sub_localization_id', ['id', '=']);
        $this->addWhereToFetchBasedOnUserByIdQuery($items, $request, 'model', ['model', 'LIKE']);
        $this->addWhereToFetchBasedOnUserByIdQuery($items, $request, 'serial', ['serial', 'LIKE']);
        $this->addWhereToFetchBasedOnUserByIdQuery($items, $request, 'producer', ['producer', 'LIKE']);
        $this->addWhereToFetchBasedOnUserByIdQuery($items, $request, 'inside_identifier', ['inside_identifier', 'LIKE']);

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
            'itemCategory'
        ])->whereHas('itemCategory', function($query) use($user_category_access) {
            $query->whereIn('id', $user_category_access);
        })->where('id', '=', $id)->firstOrFail();

        return ItemShowResurce::make($item);

    }

    protected function addWhereToFetchBasedOnUserByIdQuery(Builder &$builder, Request $request, string $user_query, array $where)
    {
        if($where[] = $request->query($user_query))
        {
            $builder->where(...$where);
        }
    }
}

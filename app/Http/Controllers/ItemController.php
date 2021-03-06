<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemListResource;
use App\Http\Resources\ItemShowResurce;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemPersonChangeHistory;
use App\Traits\AddUserFilteringToDataFetchTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{

    use AddUserFilteringToDataFetchTrait;

    /**
     * @var Request
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('is.super.user')->only('destroy');
    }

    /**
     * Shows a list of items which for user has at least access to one category
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('read');
        $items = Item::with([
            'person',
            'localization',
            'subLocalization',
        ])->whereHas('itemCategory', function($query) use($user_category_access) {
            $this->addUserFilteringToDataFetch($query, 'item_category_id', 'whereIn', ['category_id']);
            $query->whereIn('category_id', $user_category_access);
        });

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

    /**
     * @param int $id
     * @return ItemShowResurce
     */
    public function show(int $id)
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('read');

        $item = Item::with([
            'person',
            'localization',
            'subLocalization',
            'itemPersonChangeHistory.person'
        ])->whereHas('itemCategory', function($query) use($user_category_access) {
            $query->whereIn('category_id', $user_category_access);
        })->where('id', '=', $id)->firstOrFail();

        return ItemShowResurce::make($item);
    }

    /**
     * @return ItemShowResurce
     */
    public function store()
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('create');
        //Cast item_category_id string into array and validate
        $this->request->merge(['item_category_id' => json_decode($this->request->get('item_category_id'))]);
        //We use this to let Laravel handle if the user can write to given item_category_id by using in_array:user_category_id.*
        $this->request->merge(['user_category_access' => $user_category_access]);
        $validate_data = $this->request->validate([
            'serial' => ['required', 'string'],
            'model' => ['required', 'string'],
            'producer' => ['required', 'string'],
            'inside_identifier' => ['required', 'string'],
            'localization_id' => ['required', 'bail', 'numeric', 'exists:\App\Models\Localization,id'],
            'sub_localization_id' => ['sometimes', 'bail', 'numeric', 'exists:\App\Models\SubLocalization,id'],
            'item_category_id' => ['required','array'],
            'item_category_id.*' => ['numeric', 'bail', 'exists:\App\Models\ItemCategory,id', 'in_array:user_category_access.*']
        ]);


        $validate_data['person_id'] = $user->person_id;

        $item = new Item();

        foreach ($validate_data as $column => $value) {
            if ($column !== 'item_category_id') {
                $item->$column = $value;
            }
        }

        $item->save();

        foreach ($validate_data['item_category_id'] as $value) {
            $item_category = new ItemCategory();
            $item_category->category_id = $value;
            $item_category->item_id = $item->id;
            $item_category->save();
        }

        return ItemShowResurce::make($item);
    }

    /**
     * @param int $id
     * @return ItemShowResurce|void
     */
    public function update(int $id)
    {
        $user = Auth::user();
        $user_category_access_update = $user->getUserCategoryAccess('update');
        $user_category_access_write = $user->getUserCategoryAccess('create');
        $item_to_update = Item::with('itemCategory')->whereHas('itemCategory', function($query) use($user_category_access_update) {
            $query->whereIn('category_id', $user_category_access_update);
        })->where('id', '=', $id)->firstOrFail();
        $this->request->merge(['user_category_access' => $user_category_access_write]);
        $validate_data = $this->request->validate([
            'serial' => ['sometimes', 'string'],
            'model' => ['sometimes', 'string'],
            'producer' => ['sometimes', 'string'],
            'person_id' => ['sometimes', 'numeric',
                Rule::exists('person','id')->where(function ($query) {
                    //We make sure that only people that are employed can be assigned items
                    $query->where('is_employed', 1);
                })
            ],
            'inside_identifier' => ['sometimes', 'string'],
            'localization_id' => ['sometimes', 'bail', 'numeric', 'exists:\App\Models\Localization,id'],
            'sub_localization_id' => ['sometimes', 'bail', 'numeric', 'exists:\App\Models\SubLocalization,id'],
            'item_category_id' => ['sometimes', 'bail', 'array'],
            'item_category_id.*' => ['sometimes', 'bail', 'numeric', 'exists:\App\Models\ItemCategory,id', 'in_array:user_category_access.*']
        ]);

        if($item_to_update->is_disposed) {
            return abort('400', 'You can\'t edit an disposed item.');
        }
        foreach ($validate_data as $column => $value) {
            if($column === 'person_id') {
                if($item_to_update->person_id !== $value) {
                    $item_person_change_history_model = new ItemPersonChangeHistory();
                    $item_person_change_history_model->item_id = $item_to_update->id;
                    $item_person_change_history_model->new_person_id = $value;
                    $item_person_change_history_model->save();
                }
            }

            if ($column !== 'item_category_id') {
                $item_to_update->$column = $value;
            }
        }

        //Check what category - item relation we have to create
        $add_item_to_categories = $validate_data['item_category_id'] ?? false;
        if($add_item_to_categories) {
            foreach ($item_to_update->itemCategory as $item_category) {
                //We either delete the value from database, or update the $add_item_to_categories so it doesn't contain the category id
                if (!in_array($item_category->category_id, $add_item_to_categories)) {
                    $item_category->delete();
                } else {
                    $add_item_to_categories = array_diff($add_item_to_categories, [$item_category->id]);
                }
            }

            //Create missing category - item relation
            foreach ($add_item_to_categories as $category_id) {
                $item_category_model = new ItemCategory();
                $item_category_model->item_id = $item_to_update->id;
                $item_category_model->category_id = $category_id;
                $item_category_model->save();
            }
        }

        $item_to_update->save();

        return ItemShowResurce::make($item_to_update);
    }

    /**
     * Used for setting item to be disposed
     * @param int $id
     * @return ItemShowResurce|void
     */
    public function dispose(int $id)
    {
        $user = Auth::user();
        $user_category_access_update = $user->getUserCategoryAccess('update');
        $item_to_update = Item::with('itemCategory')->whereHas('itemCategory', function($query) use($user_category_access_update) {
            $query->whereIn('category_id', $user_category_access_update);
        })->where('id', '=', $id)->firstOrFail();
        $validate_data = $this->request->validate([
            'is_disposed' => ['required', 'boolean']
        ]);

        $item_person_user = $item_to_update->person->user;

        if(is_null($item_person_user)) {
            return abort('400', 'Item has to be assigned to an administrative user.');
        } else {
            $disposed = $validate_data['is_disposed'];
            if($disposed) {
                if($user->super_user) {
                    $item_to_update->is_disposed = true;
                    $item_to_update->disposed_by_person_id = $user->id;
                    $item_to_update->save();
                } else {
                    return abort('400', 'Only super user can make the item not disposed.');
                }
            } else {
                $item_to_update->is_disposed = false;
                $item_to_update->disposed_by_person_id = null;
                $item_to_update->save();
            }
        }

        return ItemShowResurce::make($item_to_update);
    }

    /**
     * Hard delete only available for the administrator
     * @param int $id
     * @return bool
     */
    public function destroy(int $id)
    {
        $item = Item::findOrFail($id);

        foreach ($item->itemCategory as $category) {
            $category->delete();
        }

        $item->delete();

        return true;
    }
}

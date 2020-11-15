<?php

namespace App\Http\Livewire\Item\ItemCategory;

use App\Models\ItemCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Manage extends Component
{
    public $itemCategories;
    public $availableCategories;
    public $userAvailableCategoriesArray;
    public $newCategoryId;
    public $itemId;

    public function updatedNewCategoryId($value)
    {
        $result = $this->validateOnly("newCategoryId", [
            'newCategoryId' => ['numeric', 'bail', 'exists:\App\Models\Category,id', 'in_array:userAvailableCategoriesArray.*', ]
        ]);
        dd($result);
        $item_category_model = new ItemCategory();
        $item_category_model->category_id = $value;
        $item_category_model->item_id = $this->itemId;
        $item_category_model->save();
        $this->itemCategories[] = $item_category_model;
    }

    public function render()
    {
        $user = Auth::user();
        $this->availableCategories = $user->getUserCategoryAccess('update', false);
        $this->userAvailableCategoriesArray = $this->availableCategories->pluck('id')->toArray();
        return view('livewire.item.item-category.add');
    }

    public function removeItemCategory($id)
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('update');
        $item_categories = $this->itemCategories->pluck('id')->toArray();
        $remove_category = ItemCategory::whereIn('category_id', $user_category_access)->where('id', '=', $id)->firstOrFail();
        if(in_array($id, $item_categories)) {
            $remove_category->delete();
        } else {
            $this->addError('item_categories', 'You are not permitted to remove this category');
        }
    }
}

<?php

namespace App\Http\Livewire\Item\ItemCategory;

use App\Models\ItemCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Manage extends Component
{
    public $itemCategories;
    public $userAvailableCategories;
    public $userAvailableCategoriesIdArray;
    public $newCategoryId;
    public $itemId;

    public function mount()
    {
        $this->setUserAvailableCategoriesParams();
    }

    public function updatedNewCategoryId($value)
    {
        if($value == 0) return;
        $result = $this->validateOnly("newCategoryId", [
            'newCategoryId' => ['numeric', 'bail', 'exists:\App\Models\Category,id', 'in_array:userAvailableCategoriesIdArray.*']
        ]);
        $item_category_model = new ItemCategory();
        $item_category_model->category_id = $value;
        $item_category_model->item_id = $this->itemId;
        $item_category_model->save();
        $this->itemCategories[] = $item_category_model;
        $this->setUserAvailableCategoriesParams();
    }

    public function render()
    {
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
            $this->itemCategories = $this->itemCategories->except($id);
            $this->setUserAvailableCategoriesParams();
        } else {
            $this->addError('item_categories', 'You are not permitted to remove this category');
        }
    }

    protected function setUserAvailableCategoriesParams()
    {
        $user = Auth::user();
        //We remove the $itemCategories that we already have from teh available so we don't get duplicate values
        $this->userAvailableCategories = $user->getUserCategoryAccess('update', false)->diffKeys($this->itemCategories);
        //dd($this->userAvailableCategories, $user->getUserCategoryAccess('update', false));
        $this->userAvailableCategoriesIdArray = $this->userAvailableCategories->pluck('id')->toArray();
    }
}

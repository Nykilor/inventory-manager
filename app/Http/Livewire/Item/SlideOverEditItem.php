<?php

namespace App\Http\Livewire\Item;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SlideOverEditItem extends Component
{
    public $item;
    public $edited;
    public $showAddCategoryModal = false;

    public function updateEdited()
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('read');

        $item = Item::with([
            'person',
            'localization',
            'subLocalization',
            'itemPersonChangeHistory.person'
        ]);

        if(!$user->super_user) {
            $item->whereHas('itemCategory', function($query) use($user_category_access, $user) {
                $query->whereIn('category_id', $user_category_access);
            });
        }

        $this->item = $item->where('id', '=', $this->edited)->firstOrFail();
    }

    public function render()
    {
        $this->updateEdited();
        return view('livewire.item.slide-over-item-edit-content');
    }

    public function removeItemCategory($id)
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('update');
        $item_categories = $this->item->itemCategory->pluck('id')->toArray();
        $remove_category = ItemCategory::whereIn('category_id', $user_category_access)->where('id', '=', $id)->firstOrFail();
        if(in_array($id, $item_categories)) {
            $remove_category->delete();
            $this->item->refresh();
        } else {
            var_dump(true);
        }
    }
}

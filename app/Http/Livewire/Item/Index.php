<?php

namespace App\Http\Livewire\Item;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $isOpen = false;
    public $itemId;
    public $show = false;

    public function render()
    {
        $user = Auth::user();
        $user_category_access = $user->getUserCategoryAccess('read');
        $items = Item::with([
            'person',
            'localization',
            'subLocalization',
        ]);

        if(!$user->super_user) {
            $items->whereHas('itemCategory', function($query) use($user_category_access, $user) {
                //$this->addUserFilteringToDataFetch($query, 'item_category_id', 'whereIn', ['category_id']);
                $query->whereIn('category_id', $user_category_access);
            });
        }

        return view('livewire.item.index', [
            'items' => $items->paginate(10)
        ]);
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }


    public function edit($id)
    {
        $this->itemId = $id;
        $this->openModal();
    }


}

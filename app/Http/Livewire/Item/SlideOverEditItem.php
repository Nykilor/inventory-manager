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

    protected $listeners = ['refreshItem'];

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

    public function refreshItem()
    {
        $this->item->refresh();
    }
}

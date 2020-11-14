<?php

namespace App\Http\Livewire\Item\ItemCategory;

use Livewire\Component;

class Add extends Component
{
    public $show = false;

    protected $listeners = ['toggleShowAddItemCategory'];

    public function render()
    {
        return view('livewire.item.item-category.add');
    }

    public function toggleShowAddItemCategory()
    {
        $this->show = !$this->show;
    }
}

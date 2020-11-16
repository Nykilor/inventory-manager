<div>
    @foreach($itemCategories as $itemCategory)
        <div class="block relative my-2">
            <select disabled="true"
                    class="block appearance-none w-full border text-gray-500 border-gray-200 bg-gray-200 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>{{ $itemCategory->category->name }}</option>
            </select>
            <div wire:click="removeItemCategory({{ $itemCategory->id }})" wire:key="delete-item-category-{{ $itemCategory->id }}" wire:loading.class="pointer-events-none" class="absolute text-bold z-20 inset-y-0 right-0 flex items-center px-2 text-gray-700 bg-red-500 cursor-pointer hover:bg-red-400">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24">
                    <path
                        d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/>
                </svg>
            </div>
        </div>
    @endforeach
    @if($userAvailableCategories->count() > 0)
    <div class="block relative">
        <select
            wire:key="{{ $newCategoryId }}"
            wire:model="newCategoryId"
            autocomplete="off"
            class="block appearance-none w-full bg-white border border-gray-200 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <option value="0" selected>{{ __('Select new category to add...') }}</option>
            @foreach($userAvailableCategories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
            </svg>
        </div>
    </div>
    @endif
</div>

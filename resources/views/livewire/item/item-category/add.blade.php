<div>
    @foreach($itemCategories as $itemCategory)
        <div class="block relative">
            <select disabled="true"
                    class="block appearance-none w-full border text-gray-500 border-gray-200 bg-gray-200 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>{{ $itemCategory->category->name }}</option>
            </select>
        </div>
    @endforeach
    <div class="block relative">
        <select
            class="block appearance-none w-full bg-white border border-gray-200 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" wire:model="newCategoryId">
            <option selected hidden>{{ __('Select new category to add...') }}</option>
            @foreach($availableCategories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
            </svg>
        </div>
    </div>
</div>

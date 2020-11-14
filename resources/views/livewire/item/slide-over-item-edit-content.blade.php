<div>
<header class="px-4 sm:px-6">
    <h2 class="text-lg leading-7 font-medium text-gray-900">
        {{ __('Item') }} - {{ $item->producer }} - {{ $item->model }}
    </h2>
</header>
<hr>
<div class="relative flex-1 px-4 sm:px-6">
    <div class="absolute inset-0 px-4 sm:px-6 divide-y divide-gray-400">
        <section>
            <div class="md:flex py-2">
                <div class="md:w-1/12">
                    <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="producer">
                        {{ __('Producer') }}:
                    </label>
                </div>
                <div class="md:w-11/12">
                    <input class="transition duration-150 ease-in-out bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="producer" type="text" value="{{ $item->producer }}">
                </div>
            </div>
            <div class="md:flex py-2">
                <div class="md:w-1/12">
                    <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="model">
                        {{ __('Model') }}:
                    </label>
                </div>
                <div class="md:w-11/12">
                    <input class="transition duration-150 ease-in-out bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="model" type="text" value="{{ $item->model }}">
                </div>
            </div>
            <div class="md:flex py-2">
                <div class="md:w-1/12">
                    <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="serial">
                        {{ __('Serial') }}:
                    </label>
                </div>
                <div class="md:w-11/12">
                    <input class="transition duration-150 ease-in-out bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="serial" type="text" value="{{ $item->serial }}">
                </div>
            </div>
            <div class="md:flex py-2">
                <div class="md:w-1/12">
                    <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="inside_identifier">
                        {{ __('Inside identifier') }}:
                    </label>
                </div>
                <div class="md:w-11/12">
                    <input class="transition duration-150 ease-in-out bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inside_identifier" type="text" value="{{ $item->inside_identifier }}">
                </div>
            </div>

        </section>
        <section>
            <div class="md:flex py-2">
                <div class="md:w-1/12">
                    <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="inline-full-name">
                        {{ __('Owner') }}:
                    </label>
                </div>
                <div class="md:w-11/12">
                    <input class="transition duration-150 ease-in-out bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name" type="text" value="{{ $item->person->name }} {{ $item->person->last_name }}" disabled>
                </div>
            </div>
        </section>
        <section>
            <div class="md:flex py-2 flex-col">
                <div class="md:w-12/12">
                    <label class="text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="categories">
                        {{ __('Categories') }}:
                    </label>
                </div>
                <div class="w-screen pl-2" id="categories">
                    <livewire:item.item-category.add />
                    <button class="text-sm font-medium bg-blue-500 hover:bg-blue-700 p-2 pl-2 rounded align-middle hover:bg-red-200 text-white font-bold"
                            wire:target="toggleShowAddItemCategory"
                            wire:click="$emit('toggleShowAddItemCategory')"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            wire:loading.attr="disabled"
                            wire:ignore
                            onclick="disableButtonFor(this, 500)">Add +</button>
                    @foreach($item->itemCategory as $category)
                        <span class="text-sm font-medium bg-gray-200 py-2 pl-2 rounded align-middle hover:bg-red-200">
                            {{ $category->category->name }}
                            <button wire:click="removeItemCategory({{ $category->id }})" class="text-red-700 p-2 font-bold" wire:loading.class="opacity-50 cursor-not-allowed" wire:loading.attr="disabled">X</button>
                        </span>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
</div>

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
            <div class="py-2">
                <div class="md:w-12/12">
                    <label class="text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="categories">
                        {{ __('Categories') }}:
                    </label>
                </div>
                <div class="p-4 border-4 border-solid" id="categories">
                    <livewire:item.item-category.manage :item-id="$item->id" :item-categories="$item->itemCategory" />
                </div>
            </div>
        </section>
    </div>
</div>
</div>

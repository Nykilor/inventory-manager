<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manage items
    </h2>
</x-slot>
    <div class="py-12">
        <div id="slide-over-container" class="fixed z-10 inset-0 overflow-hidden hidden" wire:ignore.self>
            <div class="absolute inset-0 overflow-hidden">
                <!--
                  Background overlay, show/hide based on slide-over state.

                  Entering: "ease-in-out duration-500"
                    From: "opacity-0"
                    To: "opacity-100"
                  Leaving: "ease-in-out duration-500"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div id="slide-over-background" class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity ease-in-out duration-500 opacity-0" onclick="hideSlideOver()" wire:ignore.self></div>
                <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                    <!--
                      Slide-over panel, show/hide based on slide-over state.

                      Entering: "transform transition ease-in-out duration-500 sm:duration-700"
                        From: "translate-x-full"
                        To: "translate-x-0"
                      Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
                        From: "translate-x-0"
                        To: "translate-x-full"
                    -->
                    <div id="slide-over-panel" class="relative w-screen max-w-screen-lg transform transition ease-in-out duration-500 sm:duration-700 translate-x-full" wire:ignore.self>
                        <!--
                             Close button, show/hide based on slide-over state.

                             Entering: "ease-in-out duration-500"
                               From: "opacity-0"
                               To: "opacity-100"
                             Leaving: "ease-in-out duration-500"
                               From: "opacity-100"
                               To: "opacity-0"
                           -->
                        <div id="slide-over-button" class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4 ease-in-out duration-500 opacity-0" wire:ignore.self>
                            <button aria-label="Close panel" class="text-gray-300 hover:text-white transition ease-in-out duration-150" onclick="hideSlideOver()">
                                <!-- Heroicon name: x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="h-full flex flex-col space-y-6 py-6 bg-white shadow-xl overflow-y-scroll">
                            <div wire:loading wire:target="edit" class="relative flex-1 px-4 sm:px-6">
                                <div class="animate-pulse bg-blue-200 p-6 rounded text-bold">Loading</div>
                            </div>
                            <div>
                            @if($itemId)
                                <livewire:item.slide-over-edit-item :edited="$itemId" :key="$itemId"/>
                            @endif
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3" wire:click="openModal()">Create new item</button>
            <table class="table-fixed w-full">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">{{ __('Producer') }}</th>
                    <th class="px-4 py-2">{{ __('Model') }}</th>
                    <th class="px-4 py-2">{{ __('Serial') }}</th>
                    <th class="px-4 py-2">{{ __('Inside identifier') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr class="hover:bg-gray-200 cursor-pointer" onclick="showSlideOver()" wire:click="edit({{ $item->id }})">
                        <td class="border px-4 py-2">{{ $item->producer }}</td>
                        <td class="border px-4 py-2">{{ $item->model }}</td>
                        <td class="border px-4 py-2">{{ $item->serial }}</td>
                        <td class="border px-4 py-2">{{ $item->inside_identifier }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $items->links() }}
        </div>
    </div>
</div>
<script>
    function showSlideOver() {
        let slideOverContainer = document.querySelector('#slide-over-container');
        let slideOverPanel = document.querySelector('#slide-over-panel');
        let slideOverBackground = document.querySelector('#slide-over-background');
        let slideOverButton = document.querySelector('#slide-over-button');

        slideOverContainer.classList.remove('hidden');
        setTimeout(function () {
            slideOverBackground.classList.remove('opacity-0');
            slideOverPanel.classList.remove('translate-x-full');
            slideOverPanel.classList.add('translate-x-0');
            slideOverButton.classList.remove('opacity-0');
        }, 100);
    }

    function hideSlideOver() {
        let slideOverContainer = document.querySelector('#slide-over-container');
        let slideOverPanel = document.querySelector('#slide-over-panel');
        let slideOverBackground = document.querySelector('#slide-over-background');
        let slideOverButton = document.querySelector('#slide-over-button');

        slideOverBackground.classList.add('opacity-0');
        slideOverPanel.classList.add('translate-x-full');
        slideOverPanel.classList.remove('translate-x-0');
        setTimeout(function () {
            slideOverContainer.classList.add('hidden');
            slideOverButton.classList.add('opacity-0');
        }, 500);
    }

    function disableButtonFor(button, amount) {
        button.classList.add('opacity-50');
        button.classList.add('cursor-not-allowed');
        button.disabled = true;

        setTimeout(function () {
            button.classList.remove('opacity-50');
            button.classList.remove('cursor-not-allowed');
            button.disabled = false;
        }, amount);
    }
</script>

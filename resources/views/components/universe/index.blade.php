<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <!-- <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Welcome to your Jetstream application!
    </h1>

    <p class="mt-6 text-gray-500 leading-relaxed">
        Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel is designed
        to help you build your application using a development environment that is simple, powerful, and enjoyable. We believe
        you should love expressing your creativity through programming, so we have spent time carefully crafting the Laravel
        ecosystem to be a breath of fresh air. We hope you love it.
    </p> -->
</div>
<a type="button" href="{{ route('universe.create') }}" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
    </svg>
    
    
    <span class="mt-2 block text-sm font-semibold text-gray-900">Create a new Universe</span>
</a>
<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    
    <!--
    This example requires some changes to your config:
    
    ```
    // tailwind.config.js
    module.exports = {
        // ...
        plugins: [
        // ...
        require('@tailwindcss/aspect-ratio'),
        ],
    }
    ```
    -->
    
    @foreach($universes as $universe)
        <!--
        This example requires some changes to your config:
        
        ```
        // tailwind.config.js
        module.exports = {
            // ...
            plugins: [
            // ...
            require('@tailwindcss/aspect-ratio'),
            ],
        }
        ```
        -->
        <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $universe->universe_name }}</h2>
           @if($universe->is_active)
            <div class="mt-2 text-sm text-green-700">
                <p>Active</p>
            </div>
            @else
            <div class="mt-2 text-sm text-red-700">
                <p>Inactive</p>
            </div>
           @endif
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            <div class="group relative">
                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                    @if($universe->universe_logo)
                        <a href="{{ route('universe.show', $universe->id ) }}" target="_blank">
                            <img src="{{ Storage::disk('s3-public')->url($universe->universe_logo) }}" alt="Image" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                        </a>
                    @else
                    <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    @endif
                </div>
                <div class="mt-4 flex justify-between">
                    <div>
                        <h3 class="text-sm text-gray-700">
                        <a href="{{ route('universe.show', $universe->id ) }}">
                            <span aria-hidden="true" class="absolute inset-0"></span>
                        </a>
                        </h3>
                        <div>
                            <div class="sm:hidden">
                                <label for="tabs" class="sr-only">Select a tab</label>
                                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                                <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option selected>My Account</option>
                                <option>Company</option>
                                <option>Team Members</option>
                                <option>Billing</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden sm:block">
                <nav class="isolate flex divide-x divide-gray-200 rounded-lg shadow" aria-label="Tabs">
                        <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->
                        <input type="hidden" id="{{ $universe->universe_slug_name }}" value="{{ $universe->id }}">
                    @if($universe->is_active)
                        <button id="unpublish" onclick="publishAction('unpublish', '{{ $universe->universe_slug_name }}')" class="text-gray-900 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">

                                <span>Un-publish</span>
                                <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                        </button>
                    @else
                        <button id="publish" onclick="publishAction('publish', '{{ $universe->universe_slug_name }}')" class="text-white rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-gradient-to-r from-red-700 shadow py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">
                            <span>Publish</span>
                            <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                        </button>
                    @endif

                </nav>
                <nav class="isolate flex divide-x divide-gray-200 rounded-lg shadow" aria-label="Tabs">
                    <button id="publish" onclick="editAction('{{ $universe->id }}')" class="text-gray-600 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-gray-300 py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">
                        <span>Edit</span>
                        <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                    </button>
                    <button id="publish" onclick="confirmDelete('{{ $universe->id }}')" class=" text-white bg-red-700 py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">
                        <span>Delete</span>
                        <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                    </button>
                </nav>
                
            </div>

            <!-- More products... -->
            </div>
        </div>
        </div>

    @endforeach

</div>



</div>

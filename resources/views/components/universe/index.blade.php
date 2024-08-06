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

    
<ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
@foreach($universes as $universe)
  <li class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow">
    <div class="flex flex-1 flex-col p-8">
        @if($universe->universe_logo)
            <a href="{{ route('universe.show', $universe->id ) }}">
                <img src="{{ Storage::disk('s3-public')->url($universe->universe_logo) }}" alt="Image" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
            </a>
        @else
        <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
        @endif
      <!-- <img class="mx-auto h-32 w-32 flex-shrink-0 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt=""> -->
      <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $universe->universe_name }}</h2>
      <dl class="mt-1 flex flex-grow flex-col justify-between">
        <dt class="sr-only">Role</dt>
        <dd class="mt-3">
            @if($universe->universe_is_active)
            <div class="mt-2 text-sm text-green-700">
                <p>Active</p>
            </div>
            @else
            <div class="mt-2 text-sm text-red-700">
                <p>Inactive</p>
            </div>
           @endif
        </dd>
      </dl>
    </div>
    <div>
      <div class="-mt-px flex divide-x divide-gray-200">
        <div class="flex w-0 flex-1">
          <div class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
            @if($universe->universe_is_active)
                <button id="unpublish" onclick="publishAction('unpublish', '{{ $universe->universe_slug_name }}')"  aria-current="page">

                        <span>Un-publish</span>
                        <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                </button>
            @else
                <button id="publish" onclick="publishAction('publish', '{{ $universe->universe_slug_name }}')"  aria-current="page">
                    <span>Publish</span>
                    <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                </button>
            @endif
        </div>

            <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->
            <input type="hidden" id="{{ $universe->universe_slug_name }}" value="{{ $universe->id }}">

        </div>
        <div class="-ml-px flex w-0 flex-1">
          <div href="tel:+1-202-555-0170" class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
            <button id="publish" onclick="editAction('{{ $universe->id }}')"  aria-current="page">
            <span>Edit</span>
            <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
            </button>
          </div>
          <!-- <div href="tel:+1-202-555-0170" class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
            <button id="publish" onclick="confirmDelete('{{ $universe->id }}')" aria-current="page">
                <span>Delete</span>
                <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
            </button>
          </div> -->
        </div>
      </div>
    </div>
  </li>
  @endforeach
  <!-- More people... -->
</ul>



</div>

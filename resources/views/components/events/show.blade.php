<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

</div>
<div class="px-4 sm:px-6 lg:px-8">
<form type="button" action="{{ route('events.registrations.create', $event->id) }}" method="GET" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  @csrf
                  <input type="hidden" name="event_id" value="{{ $event->id }}">
                  <button type="submit">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                      </svg>
                      
                      
                      <span class="mt-2 block text-sm font-semibold text-gray-900">Create a new Registration</span>
                  </button>
                </form>
  <div class="relative bg-white">
    <img class="h-56 w-full bg-gray-50 object-cover lg:absolute lg:inset-y-0 lg:left-0 lg:h-full lg:w-1/2" src="{{ Storage::disk('s3-public')->url($event->event_promo_image) }}" alt="">
    <div class="mx-auto grid max-w-7xl lg:grid-cols-2">
      <div class="px-6 pb-24 pt-16 sm:pb-32 sm:pt-20 lg:col-start-2 lg:px-8 lg:pt-32">
        <div class="mx-auto max-w-2xl lg:mr-0 lg:max-w-lg">
          <h2 class="text-base font-semibold leading-8 text-indigo-600">{{ $event->event_start_date }} - {{ $event->event_end_date }}</h2>
          <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $event->event_name }}</p>
          <p class="mt-6 text-lg leading-8 text-gray-600">{{ $event->event_about }}.</p>
          <dl class="mt-16 grid max-w-xl grid-cols-1 gap-8 sm:mt-20 sm:grid-cols-2 xl:mt-16">
            <div class="flex flex-col gap-y-3 border-l border-gray-900/10 pl-6">
              <dt class="text-sm leading-6 text-gray-600">Registered Guests</dt>
              <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">{{ $event->registered }}</dd>
            </div>

            <!-- <div class="flex flex-col gap-y-3 border-l border-gray-900/10 pl-6">
              <dt class="text-sm leading-6 text-gray-600">Registered Vendors</dt>
              <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">99.9%</dd>
            </div> -->
            <div class="flex flex-col gap-y-3 border-l border-gray-900/10 pl-6">
              <dt class="text-sm leading-6 text-gray-600">Total Revenue</dt>
              <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">${{ $event->revenue }}</dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
</div>
    <!-- <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add user</button>
      </div>
    </div> -->
    <div class="mt-8 flow-root w-full overflow-x-auto">
      <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            @if(isset ($event->registrations) && !empty($event->registrations->toArray()))
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                  <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Registration Name</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">Edit</span>
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">Delete</span>
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">View</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  @foreach($event->registrations as $registration)
                    <tr>
                      <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $registration->registration_name }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $registration->registration_start_date }} - {{ $registration->registration_end_date }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $registration->registration_type }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          <input type="hidden" id="{{ $registration->id }}" value="{{ $registration->id }}">
                          @if($registration->registration_is_active)
                              <button id="unpublish{{ $registration->id }}" onclick="publishAction('unpublish', '{{ $registration->id }}', '{{ $event->id }}')" class="block w-full rounded-md bg-green-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-current="page">

                                      <span>Published</span>
                                      <p class="text-xs">Click to unpublish</p>
                              
                              </button>
                          @else
                              <button id="publish{{ $registration->id }}" onclick="publishAction('publish', '{{ $registration->id }}', '{{ $event->id }}')"class="block w-full rounded-md bg-orange-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-current="page">
                                  <span>Un-published</span>
                                  <p class="text-xs">Click to publish</p>
                          
                              </button>
                          @endif
                      </td>
                      <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <form action="{{ route('events.registrations.edit', ['event_id' => $event->id, 'registration_id' => $registration->id]) }}" method="GET">
                            <input type="hidden" id ="registration_id{{ $registration->id }}" name="registration_id" value="{{ $registration->id }}">
                            <button class="text-green-600 hover:text-green-900">Edit<span class="sr-only">, Lindsay Walton</span></button>
                        </form>
                      </td>
                      <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <button onclick="confirmDelete('{{ $registration->id }}', '{{ $event->id }}')" class="text-red-600 hover:text-red-900">Delete<span class="sr-only">, Lindsay Walton</span></button>
                      </td>
                      <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <a href="{{ route('events.registrations.show', ['event_id' => $event->id, 'registration_id' => $registration->id, 'event_registration_id' => $registration->id]) }}" class="text-indigo-600 hover:text-indigo-900">View<span class="sr-only">, Lindsay Walton</span></a>
                      </td>
                    </tr>
                  @endforeach

                  <!-- More people... -->
                </tbody>
              </table>
            @else
              <h1>No Registrations</h1>
            @endif
          </div>
      </div>
    </div>

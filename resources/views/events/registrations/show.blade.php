<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event_registration->registration_name. ' Guest List' }}
        </h2>
    </x-slot>

<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="p-3 block h-12 w-auto" />

    <!-- <a type="button" href="{{ route('events.create') }}" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
      <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
      </svg>
      
      
      <span class="mt-2 block text-sm font-semibold text-gray-900">Create a new Attendee</span>
    </a> -->
  <div class="px-4 sm:px-6 lg:px-8">
    <!-- <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add user</button>
      </div>
    </div> -->
    <div class="mt-8 flow-root w-full">
      <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        @if(!empty($event_registration->attendances))
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Attendee Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Handle</th>

                <!-- <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                  <span class="sr-only">Edit</span>
                </th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                  <span class="sr-only">Delete</span>
                </th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                  <span class="sr-only">View</span>
                </th> -->
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @foreach($event_registration->attendances as $attendance)
                <tr>
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $attendance->attendee_first_name }} {{ $attendance->attendee_last_name }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$attendance->attendee_handle_name }}</td>
                </tr>
              @endforeach

              <!-- More people... -->
            </tbody>
          </table>
        @else
          <h1> No events scheduled</h1>
        @endif
        </div>
      </div>
    </div>
</div>

</div>


    






</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event_registration->registration_name. ' Guest List' }}
        </h2>
    </x-slot>

@if($event_registration->registration_type == 'Online Tournament')
  <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
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
            
                <div class="mx-auto max-w-2xl text-center p-6">
                  <p class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Cash Prize</p>
                  <h2 class="text-5xl font-semibold tracking-tight text-green-500 sm:text-7xl">${{ $prize }}</h2>
                </div>
        

              @if(!empty($event_registration->attendances))
              <table class="min-w-full divide-y divide-gray-300">
                  <thead>
                    <tr>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Handle</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>

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
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$attendance->attendee_handle_name }}</td>
                        @if($attendance->attendee_status == 'Eliminated')
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-red-500">{{$attendance->attendee_status }} !!</td>
                        @elseif($attendance->attendee_status == 'Champion')
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-green-500">{{$attendance->attendee_status }} !!</td>
                        @else
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-green-500"></td>
                        @endif
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          <select id="{{ $attendance->id }}status" onchange="changeParticipantStatus('{{ $attendance->id }}')" name="location" class="mt-2 block  rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm/6">
                            @if($attendance->attendee_status == 'Champion')
                              <option selected>Champion</option>
                              <option>Eliminated</option>
                              <option>Competing</option>
                            @elseif($attendance->attendee_status == 'Eliminated')
                              <option>Champion</option>
                              <option selected>Eliminated</option>
                              <option>Competing</option>
                            @else
                              <option>Champion</option>
                              <option>Eliminated</option>
                              <option selected>Competing</option>
                            @endif
                          </select>
                        </td>
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
@else
<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
          <!-- <a type="button" href="{{ route('events.create') }}" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
            </svg>
            
            
            <span class="mt-2 block text-sm font-semibold text-gray-900">Create a new Attendee</span>
          </a> -->
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="mt-8 flow-root w-full">
            <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">        

              @if(!empty($event_registration->attendances->toArray()))
              <table class="min-w-full divide-y divide-gray-300">
                  <thead>
                    <tr>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>

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
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$attendance->attendee_first_name }} {{$attendance->attendee_last_name }}</td>
                   
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$attendance->attendee_email }}</td>
                      </tr>
                    @endforeach

                    <!-- More people... -->
                  </tbody>
                </table>
              @else
                <h1> No attendees scheduled for this event yet.</h1>
              @endif
              </div>
            </div>
          </div>
      </div>

    </div>

@endif

<script>
        // let event_id = ";
       
        function changeParticipantStatus(attendance_id) {
            console.log('here');
            let registration_id = "{{ $event_registration->id }}";
            let event_id = "{{ $event_registration->event->id }}";

            // Display a confirmation dialog
            var userConfirmed = window.confirm('Are you sure you want to change the status of ' + attendance_id + ' to ' + event.target.value + '?' );

            // If the user clicks "OK" (true), redirect to another page
            if (userConfirmed) {
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax({
                url: '/events/' + event_id + '/registrations/' + registration_id + '/attendances/' + attendance_id + '/changeStatus?attendance_id=' + attendance_id + '&status=' + event.target.value, // Replace with your server endpoint
                type: "POST",
                success: function(response) {
                    // Handle success
                    console.log("Success:", response);
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error("Error:", status, error);
                }
                });
            } else {
                // If the user clicks "Cancel" (false), you can add additional actions or do nothing
                console.log('User canceled the action.');
            }
        }
  </script>
    






</x-app-layout>
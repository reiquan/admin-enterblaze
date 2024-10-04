



<div class="p-6 lg:p-8 bg-white border-b border-gray-200">

    <nav class="flex" aria-label="Breadcrumb">
      <ol role="list" class="flex space-x-4 rounded-md bg-white px-6 shadow">

        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a class="ml-4 text-lg font-medium text-gray-500 hover:text-gray-700">Create an event</a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center">
            <svg class="{{ $step == 1 ? 'h-full w-6 flex-shrink-0 text-red-700' : 'h-full w-6 flex-shrink-0 text-gray-700' }}" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            @if(isset($event->id))
            <form method="GET" action="{{ route('events.edit', $event->id) }}" >
              @csrf
              <input type="hidden" name="step" value="1" >
              <input type="hidden" name="event_id" value="{{ $event->id ?? null }}" >
              <button class="{{ $step == 1 ? 'ml-4 text-lg font-medium text-red-700 hover:text-red-400' : 'ml-4 text-sm font-medium text-gray-500 hover:text-gray-700'}}" aria-current="page">Step 1 - event Info</button>
            </form>
            @else
            <button class="{{ $step == 1 ? 'ml-4 text-lg font-medium text-red-700 hover:text-red-400' : 'ml-4 text-sm font-medium text-gray-500 hover:text-gray-700'}}" aria-current="page">Step 1 - event Info</button>
            @endif
            
          </div>
        </li>
        
        <li class="flex">
          <div class="flex items-center">
            <svg class="{{ $step == 2 ? 'h-full w-6 flex-shrink-0 text-red-700' : 'h-full w-6 flex-shrink-0 text-gray-700' }}" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            @if(isset($event->id))
            <form method="GET" action="{{ route('events.edit', $event->id) }}" >
              @csrf
              <input type="hidden" name="step" value="2" >
              <input type="hidden" name="event_id" value="{{ $event->id ?? null }}" >
              <button class="{{ $step == 2 ? 'ml-4 text-lg font-medium text-red-700 hover:text-red-400' : 'ml-4 text-sm font-medium text-gray-500 hover:text-gray-700'}}" aria-current="page">Step 2 - Event  Picture</button>
            </form>
            @else
            <div class="{{ $step == 2 ? 'ml-4 text-lg font-medium text-red-700 hover:text-red-400' : 'ml-4 text-sm font-medium text-gray-500 hover:text-gray-700'}}" aria-current="page">Step 2 - Event Picture</div>
            @endif
          </div>
        </li>
      </ol>
    </nav>

</div>

<div class="bg-gray-200 bg-opacity-25  gap-6 lg:gap-4 p-6 lg:p-8">
<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
@if($step > 1)

    @include('components.events.event-form-step-'.$step)

@else
 

  @if($event)
    <form method="POST" action="{{ route('events.update',[ 'event_id' => $event->id, 'step' => 1] ?? '') }}">
  @else
    <form method="POST" action="{{ route('events.update') }}">
    <input type="hidden" name="step" value="1" >
  @endif
    @csrf
    <div class="space-y-6">
      <div>
        <h1 class="text-lg leading-6 font-medium text-gray-900">Event Settings</h1>
        <p class="mt-1 text-sm text-gray-500">Let’s get started by filling in the information below to create your new event.</p>
      </div>

      <div>
        <label for="event_name" class="block text-sm font-medium text-gray-700"> Event Name </label>
        <div class="mt-1">
          <input type="text" name="event_name" value="{{ $event->event_name ?? '' }}" id="event_name" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
        </div>
      </div>

      <div>
        <label for="description" class="block text-sm font-medium text-gray-700"> Event Description </label>
        <div class="mt-1">
        <textarea rows="3" name="event_about" id="comment" class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm" placeholder="What is your event about?..."> {{ $event->event_about ?? '' }}</textarea>
        </div>
      </div>

      <div>
        <label for="event_address_line_1" class="block text-sm font-medium text-gray-700"> Event Address Line 1 </label>
        <div class="mt-1">
          <input type="text" name="event_address_line_1" value="{{ $event->event_address_line_1 ?? '' }}" id="event_address_line_1" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
        </div>
      </div>

      <div>
        <label for="event_address_line_2" class="block text-sm font-medium text-gray-700"> Event Address Line 2 </label>
        <div class="mt-1">
          <input type="text" name="event_address_line_2" value="{{ $event->event_address_line_2 ?? '' }}" id="event_address_line_2" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md">
        </div>
      </div>
      <div>
        <label for="event_city" class="block text-sm font-medium text-gray-700"> Event City </label>
        <div class="mt-1">
          <input type="text" name="event_city" id="event_city" value="{{ $event->event_city ?? '' }}" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
        </div>
      </div>
      <div>
        <label for="event_state"  class="block text-sm font-medium text-gray-700"> Event State </label>
        <div class="mt-1">
          <input type="text" name="event_state" id="event_state" value="{{ $event->event_state ?? '' }}" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
        </div>
      </div>
      <div>
        <label for="event_zip" class="block text-sm font-medium text-gray-700"> Event Zip </label>
        <div class="mt-1">
          <input type="text" name="event_zip" value="{{ $event->event_zip ?? '' }}" id="event_zip" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
        </div>
      </div>

      <div date-rangepicker class="block text-sm font-medium text-gray-700">
        <div class="relative">
         <label for="event_start_date" class="block text-sm font-medium text-gray-700"> Start Date: <span class="text-xs text-green-700">{{ $event->event_start_date ?? '' }}</span></label>

            <input name="event_start_date" type="datetime-local" value="" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-2/5 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start" required>
        </div>
        <span class="mx-4 text-gray-500">to</span>
        <div class="relative">
           <label for="event_start_date" class="block text-sm font-medium text-gray-700"> Start Date: <span class="text-xs text-green-700">{{ $event->event_start_date ?? '' }}</span></label>

            <input name="event_end_date" type="datetime-local" value="" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-2/5 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end" required>
        </div>
      </div>


    @if(auth()->user()->current_team_id == 1)
      <fieldset>
          <legend class="text-sm font-medium text-gray-900">Event Type</legend>

          <div class="mt-1 bg-white rounded-md shadow-sm -space-y-px">
          
            <label class="rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer focus:outline-none">
              <input type="radio" name="is_election_event" value="1" class="h-4 w-4 mt-0.5 cursor-pointer text-sky-600 border-gray-300 focus:ring-sky-500" aria-labelledby="is_election_event-0-label" aria-describedby="is_election_event-0-description">
              <div class="ml-3 flex flex-col">
                
                <span id="is_election_event-0-label" class="block text-sm font-medium"> Election Event </span>
                
              </div>
            </label>

        
            <label class="relative border p-4 flex cursor-pointer focus:outline-none">
              <input type="radio" name="is_election_event" value="0" class="h-4 w-4 mt-0.5 cursor-pointer text-sky-600 border-gray-300 focus:ring-sky-500" aria-labelledby="privacy-setting-1-label" aria-describedby="privacy-setting-1-description">
              <div class="ml-3 flex flex-col">
            
                <span id="privacy-setting-1-label" class="block text-sm font-medium"> Non-Election Event </span>
                
              </div>
            </label>
          </div>
        </fieldset>
    @endif

      <!-- <div>
        <label for="tags" class="block text-sm font-medium text-gray-700"> Tags </label>
        <input type="text" name="tags" id="tags" class="mt-1 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md">
      </div> -->

      <div class="flex justify-end">
        <a href="{{ route('events.index') }}" type="button" class="bg-white m-2 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">Cancel</a>
        <button type="submit" name="type" value ="{{ Route::is('events.edit') ? 'edit' : '' }}" class="bg-green-500 m-2 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">{{ isset($event) && !empty($event->toArray()) ? 'Update Event' : 'Save Event'}} </button>
      </div>
    </div>

  </form>
@endif


</div>
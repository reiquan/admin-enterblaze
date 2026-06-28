

<style>
.tag-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    min-height: 45px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    align-items: center;
}

.tag-wrapper input {
    border: none;
    outline: none;
    flex: 1;
    min-width: 150px;
}

.tag {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #0d6efd;
    color: white;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 14px;
}

.tag-remove {
    cursor: pointer;
    font-weight: bold;
}
</style>


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
        <div class="mt-3">
          <label for="subtitle" class="block text-sm font-medium text-gray-700"> Event Subtitle </label>
          <div class="mt-1">
            <input type="text" name="subtitle" value="{{ $event->subtitle ?? '' }}" id="subtitle" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
          </div>
        </div>
        <div class="mt-3">
          <label for="price" class="block text-sm font-medium text-gray-700"> Event Price </label>
            <div class="mt-1">
              <input type="number" name="price" value="{{ $event->price ?? '' }}" id="event_price" class="px-2 py-2 block w-1/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
            </div>
        </div>
      </div>

      <div>
        <label for="event_type" class="block text-sm font-medium text-gray-700"> Event Type <span class="text-xs text-green-700"> Current: {{ $event->event_type ?? '' }}</span> </label>
        <div class="mt-2">
            <select id="event_type" name="event_type" autocomplete="event_type" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
            <option></option>
            <option >Tradeshow</option>
            <option>Online Tournament</option>
            <option>Registration</option>
            <option>Livestream</option>
            </select>
        </div>
      </div> 
      <div>
        <label for="event_audience" class="block text-sm font-medium text-gray-700"> Audience <span class="text-xs text-green-700"> Current: {{ $event->event_audience ?? '' }}</span></label>
        <div class="mt-2">
            <select id="event_audience" name="event_audience" autocomplete="event_audience" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
              <option></option>
              <option >All Ages</option>
              <option>Adults Only</option>
              <option>NSFW</option>
            </select>
        </div>
      </div> 


      <div>
        <label for="description" class="block text-sm font-medium text-gray-700"> Event Description </label>
        <div class="mt-1">
        <textarea rows="3" name="event_about" id="comment" class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm" placeholder="What is your event about?..."> {{ $event->event_about ?? '' }}</textarea>
        </div>
      </div>

      <div>
        <label for="venue" class="block text-sm font-medium text-gray-700"> Venue Name</label>
        <div class="mt-1">
          <input type="text" name="venue" value="{{ $event->venue ?? '' }}" id="venue" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
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
            @if($event->event_start_date)
            <input name="event_start_date" type="datetime-local" value="" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-2/5 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
            @else
            <input name="event_start_date" type="datetime-local" value="" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-2/5 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start" required>
            @endif
            
        </div>
        <span class="mx-4 text-gray-500">to</span>
        <div class="relative">
           <label for="event_start_date" class="block text-sm font-medium text-gray-700"> Start Date: <span class="text-xs text-green-700">{{ $event->event_start_date ?? '' }}</span></label>
           @if($event->event_end_date)
           <input name="event_end_date" type="datetime-local" value="" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-2/5 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
           @else
            <input name="event_end_date" type="datetime-local" value="" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-2/5 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end" required>
           @endif
        </div>
      </div>
      <fieldset>
            <div class="mb-3">
              <legend class="form-label">Event Tags </legend>

              <div id="tag-container" class="tag-wrapper">
                  <input
                      type="text"
                      id="tag-input"
                      placeholder="Type a tag and press Enter"
                  >
              </div>

              <input type="hidden" name="event_tags" id="event-tags-hidden">
          </div>

      </fieldset>

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
<script>
const tagInput = document.getElementById('tag-input');
const tagContainer = document.getElementById('tag-container');
const hiddenInput = document.getElementById('event-tags-hidden');

let tags = [];

tagInput.addEventListener('keydown', function(e) {

    if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();

        let value = this.value.trim();

        if (!value) {
            return;
        }

        if (tags.includes(value.toLowerCase())) {
            this.value = '';
            return;
        }

        tags.push(value);
        renderTags();

        this.value = '';
    }
});

function renderTags() {

    document.querySelectorAll('.tag').forEach(tag => tag.remove());

    tags.forEach((tagText, index) => {

        const tag = document.createElement('div');
        tag.className = 'tag';

        tag.innerHTML = `
            <span>${tagText}</span>
            <span class="tag-remove" onclick="removeTag(${index})">&times;</span>
        `;

        tagContainer.insertBefore(tag, tagInput);
    });

    hiddenInput.value = JSON.stringify(tags);
}

function removeTag(index) {
    tags.splice(index, 1);
    renderTags();
}
</script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Registration') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

    <nav class="flex" aria-label="Breadcrumb">
    <ol role="list" class="flex space-x-4 rounded-md bg-white px-6 shadow">

        <li class="flex">
        <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
            <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a class="ml-4 text-lg font-medium text-gray-500 hover:text-gray-700">Create an event registration</a>
        </div>
        </li>
        <li class="flex">
        <div class="flex items-center">
            <svg class="{{ $step == 1 ? 'h-full w-6 flex-shrink-0 text-red-700' : 'h-full w-6 flex-shrink-0 text-gray-700' }}" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
            <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            @if(isset($event_registration->id))
            <form method="GET" action="{{ route('events.registrations.edit', $event_registration->id) }}" >
            @csrf
            <input type="hidden" name="step" value="1" >
            <input type="hidden" name="event_id" value="{{ $event_registration->id ?? null }}" >
            <button class="{{ $step == 1 ? 'ml-4 text-lg font-medium text-red-700 hover:text-red-400' : 'ml-4 text-sm font-medium text-gray-500 hover:text-gray-700'}}" aria-current="page">Event Registration Info</button>
            </form>
            @else
            <button class="{{ $step == 1 ? 'ml-4 text-lg font-medium text-red-700 hover:text-red-400' : 'ml-4 text-sm font-medium text-gray-500 hover:text-gray-700'}}" aria-current="page">Event Registration Info</button>
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

    @include('components.events.registrations.registration-form-step-'.$step)

    @else


    @if($event_registration)
    <form method="POST" action="{{ route('events.registrations.update',[ 'event_registration_id' => $event_registration->id, 'step' => 1] ?? '') }}">
    @else
    <form method="POST" action="{{ route('events.registrations.store', $event->id) }}">
    <input type="hidden" name="event_id" value="{{ $event->id }}" >
    @endif
    @csrf
    <div class="space-y-6 bg-white px-12 py-12">
    <div>
        <h1 class="text-lg leading-6 font-medium text-gray-900">Event Registration Settings</h1>
        <p class="mt-1 text-sm text-gray-500">Let’s get started by filling in the information below to create your new event.</p>
    </div>

    <div>
        <label for="registration_name" class="block text-sm font-medium text-gray-700"> Registration Name </label>
        <div class="mt-1">
        <input type="text" name="registration_name" value="{{ $event_registration->registration_name ?? '' }}" id="registration_name" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
        </div>
    </div>
    <div class="py-8">
        <label for="registration_limit" class="block text-sm font-medium text-gray-700"> Registration Limit </label>
        <div class="mt-1">
        <input type="number" name="registration_limit" id="registration_limit" value="{{ $event_registration->registration_limit ?? '' }}" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"   min="0" required>
        </div>
    </div>

    <div>
        <label for="registration_description" class="block text-sm font-medium text-gray-700"> Registration Description </label>
        <div class="mt-1">
        <textarea rows="3" name="registration_description" id="comment" class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm" placeholder="Who is your registration for?..."> {{ $event_registration->registration_description ?? '' }}</textarea>
        </div>
    </div>

    <div>
        <label for="registration_type" class="block text-sm font-medium text-gray-700"> Registration Type </label>
        <div class="mt-2">
            <select id="registration_type" name="registration_type" autocomplete="registration_type" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
            
             @if(!empty($event_registration))
                @if($event_registration->registration_type == 'Guest')
                <option selected>Guest</option>
                @else
                <option >Guest</option>
                @endif
                @if($event_registration->registration_type == 'Vendor')
                <option selected>Vendor</option>
                @else
                <option >Vendor</option>
                @endif
                @if($event_registration->registration_type == 'Artist')
                <option selected>Artist</option>
                @else
                <option >Artist</option>
                @endif
                @if($event_registration->registration_type == 'Food Vendor')
                <option selected>Food Vendor</option>
                @else
                <option >Food Vendor</option>
                @endif
             @else
             <option>Guest</option>
             <option>Vendor</option>
             <option >Artist</option>
             <option >Food Vendor</option>
             <option >Participant</option>
             @endif
            
            </select>
        </div>
    </div>  

    <div date-rangepicker class="block text-sm font-medium text-gray-700">
        <div class="relative">
        <label for="registration_start_date" class="block text-sm font-medium text-gray-700"> Start Date: <span class="text-xs text-green-700">{{ $event_registration->registration_start_date ?? '' }}</span></label>

            <input name="registration_start_date" type="datetime-local" value="{{ $event_registration->registration_start_date ?? '' }}" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-2 py-2 block w-2/5 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start" required>
        </div>
        <span class="mx-4 text-gray-500">to</span>
        <div class="relative">
        <label for="registration_end_date" class="block text-sm font-medium text-gray-700"> End Date: <span class="text-xs text-green-700">{{ $event_registration->registration_end_date ?? '' }}</span> </label>

        <input name="registration_end_date" type="datetime-local" value="{{ $event_registration->registration_end_date ?? '' }}" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-2 py-2 block w-2/5 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end" required>
    </div>
    <div class="py-8">
        <label for="registration_fee" class="block text-sm font-medium text-gray-700"> Registration Fee </label>
        <div class="mt-1">
        <input type="number" name="registration_fee" id="registration_fee" value="{{ $event_registration->registration_fee ?? '' }}" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('events.index') }}" type="button" class="bg-white m-2 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">Cancel</a>
        <button type="submit" name="type" value ="{{ Route::is('events.registrations.edit') ? 'edit' : '' }}" class="bg-green-800 m-2 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-200 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">{{ !empty($event_registration) ? 'Update Event Registration' : 'Save Event Registration'}} </button>
    </div>
    </div>

    </form>
    @endif


    </div>

</x-app-layout>
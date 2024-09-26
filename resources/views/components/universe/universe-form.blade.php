



<div class="p-6 lg:p-8 bg-white border-b border-gray-200">

    <nav class="flex" aria-label="Breadcrumb">
      <ol role="list" class="flex space-x-4 rounded-md bg-white px-6 shadow">

        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a class="ml-4 text-lg font-medium text-gray-500 hover:text-gray-700">Create a Universe</a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center">
            <svg class="{{ $step == 1 ? 'h-full w-6 flex-shrink-0 text-red-700' : 'h-full w-6 flex-shrink-0 text-gray-700' }}" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <form method="GET" action="{{ route('universe.edit', isset($universe->id) ? $universe->id : $universe_id) }}" >
              @csrf
              <input type="hidden" name="step" value="1" >
              <input type="hidden" name="universe_id" value="{{ isset($universe->id) ? $universe->id : $universe_id }}" >
              <button class="{{ $step == 1 ? 'ml-4 text-lg font-medium text-red-700 hover:text-red-400' : 'ml-4 text-sm font-medium text-gray-500 hover:text-gray-700'}}" aria-current="page">Step 1 - Universe Info</button>
            </form>
            
          </div>
        </li>
        
        <li class="flex">
          <div class="flex items-center">
            <svg class="{{ $step == 2 ? 'h-full w-6 flex-shrink-0 text-red-700' : 'h-full w-6 flex-shrink-0 text-gray-700' }}" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <form method="GET" action="{{ route('universe.edit', isset($universe->id) ? $universe->id : $universe_id) }}" >
              @csrf
              <input type="hidden" name="step" value="2" >
              <input type="hidden" name="universe_id" value="{{ isset($universe->id) ? $universe->id : $universe_id }}" >
              <button class="{{ $step == 2 ? 'ml-4 text-lg font-medium text-red-700 hover:text-red-400' : 'ml-4 text-sm font-medium text-gray-500 hover:text-gray-700'}}" aria-current="page">Step 2 - Profile Picture</button>
            </form>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center">
            <svg class="{{ $step == 3 ? 'h-full w-6 flex-shrink-0 text-red-700' : 'h-full w-6 flex-shrink-0 text-gray-700' }}" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <form method="GET" action="{{ route('universe.edit', isset($universe->id) ? $universe->id : $universe_id) }}" >
              @csrf
              <input type="hidden" name="step" value="3" >
              <input type="hidden" name="universe_id" value="{{ isset($universe->id) ? $universe->id : $universe_id }}" >
              <button class="{{ $step == 3 ? 'ml-4 text-lg font-medium text-red-700 hover:text-red-400' : 'ml-4 text-sm font-medium text-gray-500 hover:text-gray-700'}}" aria-current="page">Step 3 - Banner Upload</button>
            </form>

          </div>
        </li>
        <li class="flex">
          <div class="flex items-center">
            <svg class="{{ $step == 4 ? 'h-full w-6 flex-shrink-0 text-red-700' : 'h-full w-6 flex-shrink-0 text-gray-700' }}" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <form method="GET" action="{{ route('universe.index', isset($universe->id) ? $universe->id : $universe_id) }}" >
              @csrf
              <input type="hidden" name="step" value="4" >
              <input type="hidden" name="universe_id" value="{{ isset($universe->id) ? $universe->id : $universe_id }}" >
              <button class="{{ $step == 4 ? 'ml-4 text-lg font-medium text-red-700 hover:text-red-400' : 'ml-4 text-sm font-medium text-gray-500 hover:text-gray-700'}}" aria-current="page">Step 4 - Submit</button>
            </form>
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

    @include('components.universe.universe-form-step-'.$step)

@else
  <form method="POST" action="{{ route('universe.store') }}" >
    @csrf
    <input type="hidden" name="step" value="1" >
    @if(isset($universe->id))
    <input type="hidden" name="universe_id" value="{{ $universe->id }}" >
    @endif
    <div class="">
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li><strong>*{{ $error }}</strong></li>
                  @endforeach
              </ul>
          </div>
      @endif
      <br>
      <div class="border-b border-gray-900/10 pb-12">

        <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly so be careful what you share.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-4">
            <label for="universe_name" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">enterblazecomics.com/unverse/</span>
                <input type="text" name="universe_name" id="universe_name" value="{{ $universe->universe_name ?? ''}}" autocomplete="universe_name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="janesmith">
              </div>
            </div>
          </div>

            <div class="">
              <label for="universe_audience" class="block text-sm font-medium leading-6 text-gray-900">Audience</label>
              <div class="mt-2">
                <select id="universe_audience" name="universe_audience" autocomplete="universe_audience" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
               
                  @if($universe->universe_audience == 'Teens')
                  <option selected>Teens</option>
                  @else
                  <option >Teens</option>
                  @endif
                  @if($universe->universe_audience == 'Mature Audience')
                  <option selected>Mature Audience</option>
                  @else
                  <option >Mature Audience</option>
                  @endif
                  @if($universe->universe_audience == 'Adults Only')
                  <option selected>Adults Only</option>
                  @else
                  <option >Adults Only</option>
                  @endif
             
                </select>
              </div>
            </div>

          <div class="col-span-full">
            <label for="universe_description" class="block text-sm font-medium leading-6 text-gray-900">Universe Description</label>
            <div class="mt-2">
              <textarea id="universe_description" name="universe_description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ $universe->universe_description }}</textarea>
            </div>
            <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about your universe.</p>
          </div>

          <!-- <div class="col-span-full">
            <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Universe Photo</label>
            <div class="mt-2 flex items-center gap-x-3">
              <svg class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
              </svg>
              <button type="button" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Change</button>
            </div>
          </div> -->
        </div>
      </div>

        

      
    
          
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
      <a href="{{ route('universe.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
      <button type="submit" name="type" value ="{{ Route::is('universe.edit') ? 'edit' : '' }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
    </div>

  </form>
@endif


</div>




<div class="p-6 lg:p-8 bg-white border-b border-gray-200">

    <nav class="flex" aria-label="Breadcrumb">
      <ol role="list" class="flex space-x-4 rounded-md bg-white px-6 shadow">

        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a href="#" class="ml-4 text-lg font-medium text-gray-500 hover:text-gray-700">Create a Universe</a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Step 1 - Universe Info</a>
          </div>
        </li>
        
        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Step 2 - Profile Picture</a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Step 3 - Banner Upload</a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Step 4 - Submit</a>
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

  <form method="POST" action="" >
    @csrf
    <input type="hidden" name="step" value="{{ $step }}" >
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

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"></div>
        <div class="col-span-full"></div>
        <div class="sm:col-span-3">
          <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Profile Picture</label>
          <div class="mt-2">
            <p>{{ $_REQUEST['universe_id'] }}</p>

            @livewire('profile-upload', ['universe_id' => $_REQUEST['universe_id']])
          </div>
        </div>
      </div>
    </div>

  </form>


</div>
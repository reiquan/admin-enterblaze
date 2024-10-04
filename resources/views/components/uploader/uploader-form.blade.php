



<div class="p-6 lg:p-8 bg-white border-b border-gray-200">

    <nav class="flex" aria-label="Breadcrumb">
      <ol role="list" class="flex space-x-4 rounded-md bg-white px-6 shadow">

        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a href="#" class="ml-4 text-lg font-medium text-gray-500 hover:text-gray-700">Upload Web Comic</a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Step 1 - Series Info</a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Step 2 - Upload Pages</a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center">
            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Step 3 - Confirmation</a>
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

<form method="POST" action="{{ route('book.update') }}" >
  @csrf
  
  @include('components.uploader.uploader-form-step-'.$step)

</form>


</div>
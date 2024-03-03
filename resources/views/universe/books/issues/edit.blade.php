
<x-app-layout>
    <div class="bg-gray-200 bg-opacity-25  gap-6 lg:gap-4 p-6 lg:p-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Issue Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


               



<div class="p-6 lg:p-8 bg-white border-b border-gray-200">

<nav class="flex" aria-label="Breadcrumb">
  <ol role="list" class="flex space-x-4 rounded-md bg-white px-6 shadow">

    <li class="flex">
      <div class="flex items-center">
        <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
          <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
        </svg>
        <a href="#" class="ml-4 text-lg font-medium text-gray-500 hover:text-gray-700">Update Page </a>
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

            <h2 class="text-base font-semibold leading-7 text-gray-900">Upload/Replace Issue Page</h2>


            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"></div>
            <div class="col-span-full"></div>
            <div class="sm:col-span-3">
            <div class="mt-2">
            

                @livewire('issue-page-single-upload', ['universe_id' => $issue_page->issue->book->universe->id, 'book_id' => $issue_page->issue->book->id, 'issue_id' => $issue_page->issue->id, 'issue_page_id' => $issue_page->id])
            </div>
            </div>
        </div>
        </div>

    </form>


    </div>
</x-app-layout>

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

        <h2 class="text-base font-semibold leading-7 text-gray-900">Profile 3</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly so be careful what you share.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"></div>
        <div class="col-span-full"></div>
        <div class="sm:col-span-3">
          <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Banner Upload</label>
          <div class="mt-2">
          @livewire('banner-upload', ['universe_id' => $_REQUEST['universe_id']])
          </div>
        </div>
      </div>
    </div>

  </form>


</div>
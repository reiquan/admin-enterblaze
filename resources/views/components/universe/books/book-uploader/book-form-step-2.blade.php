

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

        <h2 class="text-base font-semibold leading-7 text-gray-900">Upload your Book Cover</h2>


        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"></div>
        <div class="col-span-full"></div>
        <div class="sm:col-span-3">
          <div class="mt-2">
        

            @livewire('book-cover-upload', ['universe_id' => $universe_id, 'book_id' => $book_id])
          </div>
        </div>
      </div>
    </div>

  </form>


</div>
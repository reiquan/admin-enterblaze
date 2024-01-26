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
    <input type="hidden" name="step" value="{{ $step }}" >
      <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly so be careful what you share.</p>

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
          <label for="universe_name" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
          <div class="mt-2">
            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
              <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">enterblazecomics.com/unverse/</span>
              <input type="text" name="universe_name" id="universe_name" autocomplete="universe_name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="janesmith">
            </div>
          </div>
        </div>

        <div class="sm:col-span-3">
          <label for="book_title" class="block text-sm font-medium leading-6 text-gray-900">Title of Book</label>
          <div class="mt-2">
            <input type="text" name="book_title" id="book_title" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div class="sm:col-span-3">
          <label for="book_subtitle" class="block text-sm font-medium leading-6 text-gray-900">Subtitle</label>
          <div class="mt-2">
            <input type="text" name="book_subtitle" id="book_subtitle" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div class="sm:col-span-3">
            <label for="book_audience" class="block text-sm font-medium leading-6 text-gray-900">Audience</label>
            <div class="mt-2">
              <select id="book_audience" name="book_audience" autocomplete="book_audience" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                <option>Teens</option>
                <option>Mature Audience</option>
                <option>Adults Only</option>
              </select>
            </div>
          </div>

        <div class="sm:col-span-3">
          <label for="book_creator" class="block text-sm font-medium leading-6 text-gray-900">Creator</label>
          <div class="mt-2">
            <input type="text" name="book_creator" id="book_creator" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div class="col-span-full">
          <label for="book_description" class="block text-sm font-medium leading-6 text-gray-900">Book Description</label>
          <div class="mt-2">
            <textarea id="book_description" name="book_description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
          </div>
          <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about your book.</p>
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

    <div class="border-b border-gray-900/10 pb-12">
      <h2 class="text-base font-semibold leading-7 text-gray-900">Create your Universe!</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">help readers find your stories faster</p>

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <label for="book_genres" class="block text-sm font-medium leading-6 text-gray-900">Genre</label>
            <div class="mt-2">
              <select id="book_genres" name="book_genres" autocomplete="book_genres" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                <option>Fantasy</option>
                <option>Action</option>
                <option>Adult</option>
              </select>
            </div>
          </div>
          <div class="sm:col-span-3">
            <label for="book_type" class="block text-sm font-medium leading-6 text-gray-900">Book Type</label>
            <div class="mt-2">
              <select id="book_type" name="book_type" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                <option>Manga</option>
                <option>Webcomic</option>
              </select>
            </div>
          </div>
          <div class="sm:col-span-1">
            <label for="issue_number" class="block text-sm font-medium leading-6 text-gray-900">Issue Number</label>
            <div class="mt-2">
              <input type="number" name="issue_number" id="issue_number" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>
          <div class="sm:col-span-1">
            <label for="volume_number" class="block text-sm font-medium leading-6 text-gray-900">Volume Number</label>
            <div class="mt-2">
              <input type="number" name="volume_number" id="volume_number" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
          </div>
        </div>

  
      </div>
      

    
  
        
  </div>

  <div class="mt-6 flex items-center justify-end gap-x-6">
    <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
  </div>





<div class="bg-gray-200 bg-opacity-25  gap-6 lg:gap-4 p-6 lg:p-8">

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

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"></div>
        <div class="sm:col-span-3">
          <div class="overflow-hidden bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
              <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                <div class="lg:pr-8 lg:pt-4">
                  <div class="lg:max-w-lg">
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Upload Your Profile Picture</p>
                    <p class="mt-6 my-16 text-lg leading-8 text-gray-600">TASK : Update Dimensions here</p>
                    @if( Route::is('events.edit') )
                          @livewire('event-image-upload', ['event_id' => isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : $event->id, 'logo' => $event->event_promo_image ?? '', 'type' => 'edit'])
                    @else
                      @livewire('event-image-upload', ['event_id' => isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : $event->id, 'logo' => $event->event_promo_image ?? '', 'type' => ''])
                    @endif
                  </div>
                </div>
                <div>
                  @if(isset($event->event_promo_image))
                      <h2 class="text-base my-6 font-semibold leading-7 text-indigo-600">Current Photo</h2>
                      <img src="{{ Storage::disk('s3-public')->url($event->event_promo_image) }}" alt="Image" class="h-full w-full object-cover object-center lg:h-full lg:w-full"></div>
                  @else
                    <img src="https://tailwindui.com/img/component-images/dark-project-app-screenshot.png" alt="Product screenshot" class="w-[48rem] max-w-none rounded-xl shadow-xl ring-1 ring-gray-400/10 sm:w-[57rem] md:-ml-4 lg:-ml-0" width="2432" height="1442">
                  @endif
              </div>
            </div>
          </div>

          <div class="mt-2">
        

           
          </div>
        </div>
      </div>
    </div>

  </form>
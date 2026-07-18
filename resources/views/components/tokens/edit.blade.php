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
<form method="POST" action="{{ route('tokens.tiers.update', $tier->id) }}">
    @csrf
    <input type="hidden" name="token_tier_id" value="{{ $tier->id }}">
  <div class="space-y-12 sm:space-y-16 p-12">
    <div>
      <h2 class="text-base font-semibold leading-7 text-gray-900">Tier Info</h2>
      <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-600">Current USD Conversion: <strong>$2.50</strong></p>

      <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
        <div class="py-8">
            <label for="token_tier_name" class="block text-sm font-medium text-gray-700"> Tier  Name </label>
            <div class="mt-1">
                <input type="text" name="token_tier_name" id="token_tier_name" value="{{ $tier->token_tier_name ?? '' }}" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
            </div>
        </div>
        <div class="py-8">
            <label for="token_tier_name" class="block text-sm font-medium text-gray-700"> Tag </label>
            <div class="mt-1">
                <input type="text" name="tag" id="token_tier_name" value="{{ $tier->tag ?? '' }}" class="px-2 py-2 block w-1/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
            </div>
        </div>
        <fieldset>
          <legend class="text-sm font-medium text-gray-900">Do you want to feature this event?</legend>

          <div class="mt-1 bg-white rounded-md shadow-sm -space-y-px">
          
            <label class="rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer focus:outline-none">
              @if(!$tier->featured)
              <input type="radio" name="featured" value="0" class="h-4 w-4 mt-0.5 cursor-pointer text-sky-600 border-gray-300 focus:ring-sky-500" aria-labelledby="is_election_event-0-label" aria-describedby="is_election_event-0-description" checked>
              @else
              <input type="radio" name="featured" value="0" class="h-4 w-4 mt-0.5 cursor-pointer text-sky-600 border-gray-300 focus:ring-sky-500" aria-labelledby="is_election_event-0-label" aria-describedby="is_election_event-0-description" >
              @endif
              <div class="ml-3 flex flex-col">
                
                <span id="is_election_event-0-label" class="block text-sm font-medium"> Do Not Feature </span>
                
              </div>
            </label>

        
            <label class="relative border p-4 flex cursor-pointer focus:outline-none">
            @if($tier->featured)
              <input type="radio" name="featured" value="1" class="h-4 w-4 mt-0.5 cursor-pointer text-sky-600 border-gray-300 focus:ring-sky-500" aria-labelledby="is_election_event-0-label" aria-describedby="is_election_event-0-description" checked>
              @else
              <input type="radio" name="featured" value="1" class="h-4 w-4 mt-0.5 cursor-pointer text-sky-600 border-gray-300 focus:ring-sky-500" aria-labelledby="is_election_event-0-label" aria-describedby="is_election_event-0-description" >
              @endif
              <div class="ml-3 flex flex-col">
            
                <span id="privacy-setting-1-label" class="block text-sm font-medium"> Feature </span>
                
              </div>
            </label>
          </div>
        </fieldset>

        <div class="col-span-full mb-3">
          <label for="token_tier_description" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Description</label>
          <div class="mt-2">
            <textarea id="token_tier_description" name="token_tier_description" rows="3" class="p-6 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ $tier->token_tier_description ?? ''}}</textarea>
          </div>
          <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about the tier.</p>
        </div>

        <div class="py-8">
            <label for="token_tier_amount" class="block text-sm font-medium text-gray-700"> Blaze Token Amount </label>
            <div class="mt-1">
                <input type="number" name="token_tier_amount" id="token_tier_amount"  value="{{ $tier->token_tier_amount ?? '' }}" min="0" class="px-2 py-2 block w-2/5 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm border-gray-300 rounded-md"  required>
                <label for="token_tier_usd_price" class="mt-3block text-sm font-medium text-gray-300"> Conversion to USD:</label>
                <p class="p-3 text-gray-400" id="usd_conversion">{{ '$'. $tier->token_tier_usd_price ?? '0.00' }}</p>
                <input type="hidden" name="token_tier_usd_price" id="token_tier_usd_price" value="{{$ier-> token_tier_usd_price ?? '' }}" autocomplete="given-name" class="p-3 block w-full rounded-md border-0 py-1.5 text-gray-400 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
            </div>
        </div>
      </div>
    </div>
    <fieldset>
            <div class="mb-3">
              <legend class="form-label">Perks</legend>

              <div id="tag-container" class="tag-wrapper">
                  <input
                      type="text"
                      id="tag-input"
                      placeholder="Type a tag and press Enter"
                  >
              </div>

              <input type="hidden" name="perks" id="event-tags-hidden">
          </div>

      </fieldset>

 
  </div>

  <div class="mt-6 flex items-center justify-end gap-x-6 p-6">
    <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
    <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
  </div>
</form>

<script>
    let conversion = document.getElementById('token_tier_amount');
    console.log(conversion.value);
    conversion.onchange = function() {   

        let usdConversion = document.getElementById('token_tier_usd_price');
        

        usdConversion.value = conversion.value * 2.50.toFixed(2);

        let truncatedNumber = Math.floor(usdConversion.value * 100) / 100;

        usd = document.getElementById('usd_conversion').innerHTML = '$' + truncatedNumber.toFixed(2);


        console.log(usdConversion.value);

    };
</script>
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
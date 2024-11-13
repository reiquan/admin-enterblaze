
<div class="px-4 sm:px-6 lg:px-8 p-3">
        <!-- <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add user</button>
        </div>
        </div> -->
        <a type="button" href="{{ route('tokens.tiers.create') }}" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
            </svg>
            
            
            <span class="mt-2 block text-sm font-semibold text-gray-900">Create a new Tier</span>
        </a>
        <div class="mt-8 flow-root w-full overflow-x-auto">
        <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            @if(!empty($tiers->toArray()))
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Tier Name</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Blaze Tokens</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tier USD Amount</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                    <span class="sr-only">Edit</span>
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                    <span class="sr-only">Delete</span>
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                    <span class="sr-only">View</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach($tiers as $tier)
                    <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $tier->token_tier_name }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tier->token_tier_amount }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tier->token_tier_usd_price }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <input type="hidden" id="{{ $tier->id }}" value="{{ $tier->id }}">
                        @if($tier->token_tier_is_active)
                            <button id="unpublish{{ $tier->id }}" onclick="publishAction('unpublish', '{{ $tier->id }}')" class="block w-full rounded-md bg-green-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-current="page">

                                    <span>Published</span>
                                    <p class="text-xs">Click to unpublish</p>
                                    <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                            </button>
                        @else
                            <button id="publish{{ $tier->id }}" onclick="publishAction('publish', '{{ $tier->id }}')"class="block w-full rounded-md bg-orange-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" aria-current="page">
                                <span>Un-published</span>
                                <p class="text-xs">Click to publish</p>
                                <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                            </button>
                        @endif
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <form action="{{ route('tokens.tiers.edit', ['tier_id' => $tier->id]) }}" method="GET">
                            <input type="hidden" id ="tier_id{{ $tier->id }}" name="tier_id" value="{{ $tier->id }}">
                            <button class="text-green-600 hover:text-green-900">Edit<span class="sr-only">, Lindsay Walton</span></button>
                        </form>
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <button onclick="confirmDelete('{{ $tier->id }}')" class="text-red-600 hover:text-red-900">Delete<span class="sr-only">, Lindsay Walton</span></button>
                    </td>

                    </tr>
                @endforeach

                <!-- More people... -->
                </tbody>
            </table>
            @else
            <h1> No tiers scheduled</h1>
        @endif
            </div>
        </div>
        </div>
    </div>
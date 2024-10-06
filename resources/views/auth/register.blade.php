<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            @if (app()->environment('beta'))
                <div class="ml-3 mb-4 text-sm leading-6">
                    <label for="creator_community_opt_in" class="font-medium text-orange-700 ml-24">Early Access Users Only</label>
                    <p id="creator_community_opt_in" class="text-gray-500">Only users with the <strong>access code</strong> may sign up currently.
                        <br>
                         Try again later.
                    </p>
                </div>
            @endif
            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block py-2 px-2 mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block py-2 px-2 mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block py-2 px-2 mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block py-2 px-2 mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>
            @if (app()->environment('beta'))
                <div class="mt-4 mb-4">
                    <x-label for="beta_code" value="{{ __('Early Access Code') }}" class="text-orange-700" />
                    <x-input id="beta_code" class="block py-2 px-2 mt-1 w-full" type="text" name="beta_code" />
                </div>
            @endif
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
<fieldset>
  <legend class="py-3 sr-only">Notifications</legend>
  <div class="space-y-5">
    <div class="relative flex items-start">
      <div class="flex h-6 items-center">
        <input id="creator_community_opt_in" aria-describedby="creator_community_opt_in" name="creator_community_opt_in" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
      </div>
      <div class="ml-3 text-sm leading-6">
        <label for="creator_community_opt_in" class="font-medium text-gray-900">Creator Community</label>
        <p id="creator_community_opt_in" class="text-gray-500">Get notified on upcoming tradeshows, game tournaments and other events.</p>
      </div>
    </div>
  </div>
</fieldset>


            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

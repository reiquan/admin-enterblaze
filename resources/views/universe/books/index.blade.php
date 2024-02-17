<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($universe->universe_name.': Books ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-universe.books.index :universe="$universe" :books="$books"/>
            </div>
        </div>
    </div>

    <script>
        function publishAction(action, slug, book_id) {
            console.log('here');
            let confirm = document.getElementById(action);
            let id = document.getElementById(slug);
            let universe_id = id.value;

            // Display a confirmation dialog
            var userConfirmed = window.confirm('Are you sure you want to ' + action + ' universe ' + slug + '?');

            // If the user clicks "OK" (true), redirect to another page
            if (userConfirmed) {
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax({
                url: '/universe/' + universe_id + '/books/' + book_id + '/publish?action=' + action, // Replace with your server endpoint
                type: "POST",
                success: function(response) {
                    // Handle success
                    console.log("Success:", response);
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error("Error:", status, error);
                }
                });
            } else {
                // If the user clicks "Cancel" (false), you can add additional actions or do nothing
                console.log('User canceled the action.');
            }
        }
    </script>
</x-app-layout>
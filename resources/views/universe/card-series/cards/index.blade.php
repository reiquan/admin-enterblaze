<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-800 leading-tight">
            {{ __($universe->universe_name.': cards ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-universe.card-series.cards.index :universe="$universe" :cards="$cards" :card_series_id="$card_series_id"/>
            </div>
        </div>
    </div>

    <script>
        function publishAction(action, series_id, card_id) {
            console.log('here');
            let confirm = document.getElementById(action);
            let id = document.getElementById('u_id'+card_id);
            let universe_id = id.value;

            // Display a confirmation dialog
            var userConfirmed = window.confirm('Are you sure you want to ' + action + ' card ' + card_id + '?');

            // If the user clicks "OK" (true), redirect to another page
            if (userConfirmed) {
                $(document).ready(function() {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                    url: '/universe/' + universe_id + '/card-series/' + series_id + '/cards/' + card_id + '/publish?action=' + action + '&card_id=' + card_id, // Replace with your server endpoint
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
                });
            } else {
                // If the user clicks "Cancel" (false), you can add additional actions or do nothing
                console.log('User canceled the action.');
            }
        }
    </script>
    <script>

        function confirmDelete(id) {
            console.log('here');
            let universe_id = document.getElementById("u_id" + id).value;
            let card_id = document.getElementById("c_id" + id).value;
            let card_series_id = document.getElementById("cc_id" + id).value;
    

            // Display a confirmation dialog
            var userConfirmed = window.confirm('**WARNING** Deleting a card will delete all issues associated with it. Are you sure you want to delete card ' + card_id + '?');

            // If the user clicks "OK" (true), redirect to another page
            if (userConfirmed) {
                $(document).ready(function() {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                    url: '/universe/' + universe_id + '/card-series/' + card_series_id +'/cards/' + card_id + '/delete?card_id=' + card_id, // Replace with your server endpoint
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
                });
            } else {
                // If the user clicks "Cancel" (false), you can add additional actions or do nothing
                console.log('User canceled the action.');
            }
        }
    </script>
</x-app-layout>
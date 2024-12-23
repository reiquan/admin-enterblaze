<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-red-800">
            {{ __($event->event_name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-events.show :event="$event"/>
            </div>
        </div>
    </div>
    <script>
        function publishAction(action, registration_event_id, event_id) {
            console.log('here');
            let confirm = document.getElementById(action);
            let id = document.getElementById(registration_event_id);
            let r_id = id.value;

            // Display a confirmation dialog
            var userConfirmed = window.confirm('Are you sure you want to ' + action + ' registration ' + r_id + '?');

            // If the user clicks "OK" (true), redirect to another page
            if (userConfirmed) {
                $(document).ready(function() {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                    url: '/events/' + event_id + '/registrations/' + registration_event_id + '/publish?action=' + action + '&registration_event_id=' + registration_event_id, // Replace with your server endpoint
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

        function confirmDelete(registration_event_id,  event_id) {
            console.log('here');


            // Display a confirmation dialog
            var userConfirmed = window.confirm('**WARNING** Deleting a registration will delete all content associated with it. Are you sure you want to delete event ' + registration_event_id + '?');

            // If the user clicks "OK" (true), redirect to another page
            if (userConfirmed) {
                $(document).ready(function() {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                    url: '/events/' + event_id + '/registrations/' +registration_event_id + '/delete?registration_event_id=' + registration_event_id, // Replace with your server endpoint
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

        function editAction(id) {
            console.log('here');

            window.location.assign('/event/' + id + '/edit');
            // Display a confirmation dialog

            // If the user clicks "OK" (true), redirect to another page
            
        }
    </script>
</x-app-layout>
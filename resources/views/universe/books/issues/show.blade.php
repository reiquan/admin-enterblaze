<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($book->book_title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-universe.books.issues.show :book="$book" :issue="$issue" :pages="$pages"/>
            </div>
        </div>
    </div>

    <script>
        function isVisible(page_id, action) {
            console.log('here');
            let universe_id = document.getElementById("u_id").value;
            let book_id = document.getElementById("b_id").value;
            let issue_id = document.getElementById("i_id").value;
    

            // Display a confirmation dialog
            var userConfirmed = window.confirm('Are you sure you want to ' + action + ' page ' + page_id + '?');

            // If the user clicks "OK" (true), redirect to another page
            if (userConfirmed) {
                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        });
                        $.ajax({
                        url: '/universe/' + universe_id + '/books/' + book_id + '/issues' + '/' + issue_id + '/pages' + '/' + page_id + '/pageIsVisible?issue_page_id=' + page_id, // Replace with your server endpoint
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

        function confirmDelete(page_id) {
            console.log('here');
            let universe_id = document.getElementById("u_id").value;
            let book_id = document.getElementById("b_id").value;
            let issue_id = document.getElementById("i_id").value;
    

            // Display a confirmation dialog
            var userConfirmed = window.confirm('Are you sure you want to delete page ' + page_id + '?');

            // If the user clicks "OK" (true), redirect to another page
            if (userConfirmed) {
                $(document).ready(function() {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                    url: '/universe/' + universe_id + '/books/' + book_id + '/issues' + '/' + issue_id + '/pages' + '/' + page_id + '/delete?issue_page_id=' + page_id, // Replace with your server endpoint
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
        // // Get the select element
        // var selectElement = document.getElementById('issue_page_number');

        // // Add an event listener for the 'change' event
        // selectElement.addEventListener('change', function() {
        // // This function will be called when the value of the select element changes
        // var selectedValue = selectElement.value;
        // console.log('Selected option: ' + selectedValue);
        
        // // You can perform other actions based on the selected option here
        // });

        function swapPageNumber(page_id) {
            console.log('here');
            let universe_id = document.getElementById("u_id").value;
            let book_id = document.getElementById("b_id").value;
            let issue_id = document.getElementById("i_id").value;
            var selectElement = document.getElementById('issue_page_number'+page_id);
            var selectedValue = selectElement.value;
            console.log('Selected page: ' + selectedValue);
            // Display a confirmation dialog
            var userConfirmed = window.confirm('Are you sure you want to change to page  ' + selectedValue + '? ');

            

            // If the user clicks "OK" (true), redirect to another page
            if (userConfirmed) {
                $(document).ready(function() {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                    url: '/universe/' + universe_id + '/books/' + book_id + '/issues' + '/' + issue_id + '/pages' + '/' + page_id + '/swapPageNumber?issue_page_id=' + page_id + '&swapFor=' + selectedValue + '&issue_id=' + issue_id, // Replace with your server endpoint
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
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            @if(isset($_REQUEST['step']))
          
                <x-events.event-form :step="$step" :event="$event"/>
            @else
        
                <x-events.event-form :step="$step" :event="$event"/>
            @endif
        
            </div>
        </div>
    </div>
    <script>
         ul = document.getElementById("options");
        function myFunction() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("combobox");
            filter = input.value.toUpperCase();
            ul = document.getElementById("options");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("span")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>

    <script>
    // Create a "close" button and append it to each list item
    var ul = document.getElementById("attendees");
    var myNodelist = ul.getElementsByTagName("LI");
    // var myNodelist = document.getElementsByTagName("LI");
    var i;
    for (i = 0; i < myNodelist.length; i++) {
        var span = document.createElement("SPAN");
        var txt = document.createTextNode("\u00D7");
        span.className = "close";
        span.appendChild(txt);
        myNodelist[i].appendChild(span);
    }

    // Click on a close button to hide the current list item
    var close = document.getElementsByClassName("close");
    var i;
    for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
        var div = this.parentElement;
        div.style.display = "none";
    }
    }

    // Add a "checked" symbol when clicking on a list item
    var list = document.querySelector('ul');
    list.addEventListener('click', function(ev) {
    if (ev.target.tagName === 'LI') {
        ev.target.classList.toggle('checked');
    }
    }, false);

    // Create a new list item when clicking on the "Add" button
    function newElement(id) {
   

        var ul = document.getElementById("options");
        // console.log(ul.querySelector('#' + id).textContent);
        var inputValue = ul.querySelector('#' + id).textContent;

        var li = document.createElement("li");
        li.classList.add("py-4");
        li.classList.add("flex");
        var txt = '#' + id;
        var newtxt = txt.replace(/[^0-9]/g,'');
        var input = document.createElement("input");

        input.setAttribute("type", "hidden");

        input.setAttribute("name", "attendees[]");

        input.setAttribute("value", newtxt);

        li.appendChild(input);

        // var img = document.createElement("IMG");
        // img.setAttribute("src", "https://images.unsplash.com/photo-1513910367299-bce8d8a0ebf6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80");
        // img.classList.add("h-10");
        // img.classList.add("w-10");
        // img.classList.add("rounded-full");
        // img.setAttribute("alt", "The Pulpit Rock");

        var div = document.createElement("DIV");
        div.classList.add("ml-3");
        div.classList.add("flex");
        div.classList.add("flex-col");

        
        var span2 = document.createElement("span");
         span2.classList.add("text-sm");
         span2.classList.add("font-medium");
         span2.classList.add("text-gray-900");
         span2.classList.add("m-auto");
         span2.textContent = inputValue;


         div.prepend(span2);
        //  div.prepend(span2);
        

        li.appendChild(div);

        // li.prepend(img);


        // var t = document.createTextNode(inputValue);
        // li.appendChild(t);
        if (inputValue === '') {
            alert("You must write something!");
        } else {
            document.getElementById("myUL").appendChild(li);
        }
        // document.getElementById('#' + id).value = "";

        var span = document.createElement("SPAN");
        var txt = document.createTextNode("\u00D7");
        span.className = "close";
        span.appendChild(txt);
        li.appendChild(span);

        for (i = 0; i < close.length; i++) {
            close[i].onclick = function() {
            var div = this.parentElement;
            div.style.display = "none";
            }
        }
    }
    </script>
</x-app-layout>
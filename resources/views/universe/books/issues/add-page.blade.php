
<x-app-layout>
    <div class="bg-gray-200 bg-opacity-25  gap-6 lg:gap-4 p-6 lg:p-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Issue Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


               



<div class="p-6 lg:p-8 bg-white border-b border-gray-200">

<nav class="flex" aria-label="Breadcrumb">
  <ol role="list" class="flex space-x-4 rounded-md bg-white px-6 shadow">

    <li class="flex">
      <div class="flex items-center">
        <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
          <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
        </svg>
        <a href="#" class="ml-4 text-lg font-medium text-gray-500 hover:text-gray-700">Add Page </a>
      </div>
    </li>
  </ol>
</nav>

</div>

<div class="bg-gray-200 bg-opacity-25  gap-6 lg:gap-4 p-6 lg:p-8">
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
<!-- component -->

@csrf
  <div class="bg-gray-500 sm:px-8 md:px-16 sm:py-8">
        <main class="container mx-auto max-w-screen-lg h-full">
          <!-- file upload modal -->
          <article aria-label="File Upload Modal" class="relative h-full flex flex-col bg-white shadow-xl rounded-md" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" ondragleave="dragLeaveHandler(event);" ondragenter="dragEnterHandler(event);">
            <!-- overlay -->
            <div id="overlay" class="w-full h-full absolute top-0 left-0 pointer-events-none z-50 flex flex-col items-center justify-center rounded-md">
              <i>
                <svg class="fill-current w-12 h-12 mb-3 text-blue-700" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path d="M19.479 10.092c-.212-3.951-3.473-7.092-7.479-7.092-4.005 0-7.267 3.141-7.479 7.092-2.57.463-4.521 2.706-4.521 5.408 0 3.037 2.463 5.5 5.5 5.5h13c3.037 0 5.5-2.463 5.5-5.5 0-2.702-1.951-4.945-4.521-5.408zm-7.479-1.092l4 4h-3v4h-2v-4h-3l4-4z" />
                </svg>
              </i>
              <p class="text-lg text-blue-700">Drop files to upload</p>
            </div>

            <!-- scroll area -->
            <section class="h-full overflow-auto p-8 w-full h-full flex flex-col">
              <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center">
                <p class="mb-3 font-semibold text-gray-900 flex flex-wrap justify-center">
                  <span>Drag and drop your</span>&nbsp;<span>files anywhere or</span>
                </p>
                <input id="hidden-input" type="file" multiple class="hidden" />
                <button id="button" class="mt-2 rounded-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none">
                  Upload a file
                </button>
              </header>

              <h1 class="pt-8 pb-3 font-semibold sm:text-lg text-gray-900">
                To Upload
              </h1>

              <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                <li id="empty" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                  <img class="mx-auto w-32" src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png" alt="no data" />
                  <span class="text-small text-gray-500">No files selected</span>
                </li>
              </ul>
            </section>

            <!-- sticky footer -->
            <footer class="flex justify-end px-8 pb-8 pt-4">
              <p class=" w-1/6 px-9 py-1 text-red-500 focus:shadow-outline focus:outline-none" id="error"></p>
              <button id="submit" class="rounded-sm px-3 py-1 bg-blue-700 hover:bg-blue-500 text-white focus:shadow-outline focus:outline-none">
                Upload now
              </button>
              <button id="cancel" class="ml-3 rounded-sm px-3 py-1 hover:bg-gray-300 focus:shadow-outline focus:outline-none">
                Cancel
              </button>
            </footer>
          </article>
        </main>
      </div>
<!-- </form> -->

    <!-- using two similar templates for simplicity in js code -->
    <template id="file-template">
      <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
        <article tabindex="0" class="group w-full h-full rounded-md focus:outline-none focus:shadow-outline elative bg-gray-100 cursor-pointer relative shadow-sm">
          <img alt="upload preview" class="img-preview hidden w-full h-full sticky object-cover rounded-md bg-fixed" />

          <section class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
            <h1 class="flex-1 group-hover:text-blue-800"></h1>
            <div class="flex">
              <span class="p-1 text-blue-800">
                <i>
                  <svg class="fill-current w-4 h-4 ml-auto pt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M15 2v5h5v15h-16v-20h11zm1-2h-14v24h20v-18l-6-6z" />
                  </svg>
                </i>
              </span>
              <p class="p-1 size text-xs text-gray-700"></p>
              <button class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md text-gray-800">
                <svg class="pointer-events-none fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path class="pointer-events-none" d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                </svg>
              </button>
            </div>
          </section>
        </article>
      </li>
    </template>

    <template id="image-template">
      <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-3/5">
        <article tabindex="0" class="group hasImage w-full h-full rounded-md focus:outline-none focus:shadow-outline bg-gray-100 cursor-pointer relative text-transparent hover:text-white shadow-sm">
          <img alt="upload preview" class="img-preview w-full h-full sticky object-cover rounded-md bg-fixed" />

          <section class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
            <h1 class="flex-1"></h1>
            <div class="flex">
              <span class="p-1">
                <i>
                  <svg class="fill-current w-4 h-4 ml-auto pt-" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M5 8.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5zm9 .5l-2.519 4-2.481-1.96-4 5.96h14l-5-8zm8-4v14h-20v-14h20zm2-2h-24v18h24v-18z" />
                  </svg>
                </i>
              </span>

              <p class="p-1 size text-xs"></p>
              <button class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md">
                <svg class="pointer-events-none fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path class="pointer-events-none" d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                </svg>
              </button>
            </div>
          </section>
        </article>
      </li>
    </template>

<script>
const fileTempl = document.getElementById("file-template"),
  imageTempl = document.getElementById("image-template"),
  empty = document.getElementById("empty");

// use to store pre selected files
let FILES = {};

let uploadError = document.getElementById('error');
console.log(uploadError);
// check if file is of type image and prepend the initialied
// template to the target element
function addFile(target, file) {

  const isImage = file.type.match("image.*"),
  objectURL = URL.createObjectURL(file);

    //make surre the size isnt too big
  if(file.size > 15000000){
    
    uploadError.innerHTML = "Make sure size is less than 15 GB";

    console.log(file.size);
    return;
  } else {
    uploadError.text = "";
  }
  const clone = isImage
    ? imageTempl.content.cloneNode(true)
    : fileTempl.content.cloneNode(true);

  clone.querySelector("h1").textContent = file.name;
  clone.querySelector("li").id = objectURL;
  clone.querySelector(".delete").dataset.target = objectURL;
  clone.querySelector(".delete").id = 'delete' + objectURL;
  clone.querySelector(".delete").value = '';
  let dname = 'delete' + objectURL;
  // clone.querySelector(".delete").value = file.name;
  clone.querySelector(".size").textContent =
    file.size > 1024
      ? file.size > 1048576
        ? Math.round(file.size / 1048576) + "mb"
        : Math.round(file.size / 1024) + "kb"
      : file.size + "b";

  isImage &&
    Object.assign(clone.querySelector("img"), {
      src: objectURL,
      alt: file.name
    });


  empty.classList.add("hidden");
  target.prepend(clone);
  sendImage(objectURL, file, dname);

  // FILES[objectURL] = file;
}


const gallery = document.getElementById("gallery"),
  overlay = document.getElementById("overlay");

// click the hidden input of type file if the visible button is clicked
// and capture the selected files
const hidden = document.getElementById("hidden-input");
document.getElementById("button").onclick = (e) => {
  hidden.click();
  
}
hidden.onchange = (e) => {
  for (const file of e.target.files) {
    addFile(gallery, file);
  }
};

// use to check if a file is being dragged
const hasFiles = ({ dataTransfer: { types = [] } }) =>
  types.indexOf("Files") > -1;

// use to drag dragenter and dragleave events.
// this is to know if the outermost parent is dragged over
// without issues due to drag events on its children
let counter = 0;

// reset counter and append file to gallery when file is dropped
function dropHandler(ev) {
  ev.preventDefault();
  for (const file of ev.dataTransfer.files) {
    addFile(gallery, file);
    overlay.classList.remove("draggedover");
    counter = 0;
  }
}

// only react to actual files being dragged
function dragEnterHandler(e) {
  e.preventDefault();
  if (!hasFiles(e)) {
    return;
  }
  ++counter && overlay.classList.add("draggedover");
}

function dragLeaveHandler(e) {
  1 > --counter && overlay.classList.remove("draggedover");
}

function dragOverHandler(e) {
  if (hasFiles(e)) {
    e.preventDefault();
  }
}
function sendImage(objURL, file, dname) {
  // Convert the Object URL to a Blob
  let id = null;
  fetch(objURL)
  .then(response => response.blob())
  .then(blob => {
    // Create FormData and append the Blob
    var formData = new FormData();
    formData.append("file", blob, file.name);
    var u_id = "<?php echo $issue->book->universe->id; ?>";
    var b_id = "<?php echo $issue->book->id; ?>";
    var i_id = "<?php echo $issue->id; ?>";
    formData.append("universe_id",u_id);
    formData.append("book_id",b_id);
    formData.append("issue_id",i_id);
    // Perform the AJAX request using jQuery
    $(document).ready(function() {
      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
      $.ajax({
        url: '/universe/' + u_id + '/books/' + b_id + '/issues/' + i_id + '/update', // Replace with your server endpoint
        type: "POST",
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting contentType
        success: function(response) {
          // Handle success
          console.log("Success:", response);
          console.log();
          let id = response.issue_page_id;

          // // Create a hidden input element
          var hiddenInput = document.createElement('input');
          hiddenInput.type = 'hidden';
          hiddenInput.id = response.issue_page_id;
          hiddenInput.name = 'issue_page' + response.issue_page_id; // Set the name attribute if needed
          hiddenInput.value = response.issue_page_id; // Set the initial value if needed
          document.body.appendChild(hiddenInput);
          console.log(objURL);
          let nname = document.getElementById(dname);
          nname.value = response.issue_page_id;
          console.log('ayyye');
          console.log(nname.value);

          console.log(id);

        },
        error: function(xhr, status, error) {
          // Handle error
          console.error("Error:", status, error);
        }
      });
    });
  })
  .catch(error => {
    // Handle fetch or blob conversion error
    console.error("Error:", error);
  });
  
}

// event delegation to caputre delete events
// fron the waste buckets in the file preview cards
gallery.onclick = ({ target }) => {
  if (target.classList.contains("delete")) {
    const ou = target.dataset.target;
    console.log(ou);
    let imj =  document.getElementById('delete' + ou).value;
    console.log(imj);

    // Create FormData and append the Blob
    var formData = new FormData();
    var u_id = "<?php echo $issue->book->universe->id; ?>";
    var b_id = "<?php echo $issue->book->id; ?>";
    var i_id = "<?php echo $issue->id; ?>";
    formData.append("universe_id",u_id);
    formData.append("book_id",b_id);
    formData.append("issue_id",i_id);
    formData.append("issue_page_id",imj);
    // Perform the AJAX request using jQuery
    $(document).ready(function() {
      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
      $.ajax({
        url: '/universe/' + u_id + '/books/' + b_id + '/issues/' + i_id +  '/pages/' + imj + '/delete', // Replace with your server endpoint
        type: "POST",
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting contentType
        success: function(response) {
          // Handle success
          console.log("Success:", response);

        },
        error: function(xhr, status, error) {
          // Handle error
          console.error("Error:", status, error);
        }
      });
    });






    document.getElementById(ou).remove(ou);
    gallery.children.length === 1 && empty.classList.remove("hidden");
    console.log(FILES[ou]);
    delete FILES[ou];
  }
};

// print all selected files
document.getElementById("submit").onclick = (e) => {
  e.preventDefault();
  alert(`Submitted Files`);
 
  console.log(FILES);

  var formData = new FormData();
  var fileInput = document.getElementById('hidden-input');
  var u_id = "<?php echo $issue->book->universe->id; ?>";
    var b_id = "<?php echo $issue->book->id; ?>";
    var i_id = "<?php echo $issue->id; ?>";
  window.location.assign('/universe/' + u_id + '/books/' + b_id  + '/show?b_id=' + b_id +'&u_id=' + u_id);

};

// clear entire selection
document.getElementById("cancel").onclick = () => {
  while (gallery.children.length > 0) {
    gallery.lastChild.remove();
  }
  FILES = {};
  empty.classList.remove("hidden");
  gallery.append(empty);
};

</script>

<style>
.hasImage:hover section {
  background-color: rgba(5, 5, 5, 0.4);
}
.hasImage:hover button:hover {
  background: rgba(5, 5, 5, 0.45);
}

#overlay p,
i {
  opacity: 0;
}

#overlay.draggedover {
  background-color: rgba(255, 255, 255, 0.7);
}
#overlay.draggedover p,
#overlay.draggedover i {
  opacity: 1;
}

.group:hover .group-hover\:text-blue-800 {
  color: #2b6cb0;
}
</style>


    </div>
</x-app-layout>
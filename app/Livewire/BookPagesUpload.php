<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\Book;
use App\Http\Controllers\UploadController;
use Livewire\WithFileUploads;

class BookPagesUpload extends Component
{
    use WithFileUploads;

    public $photos = [];
    public $universe_id;
    public $book_id;

    public function mount($universe_id, $book_id)
    {
        $this->universe_id = $universe_id;
        $this->book_id = $book_id;
    }



    public function uploadMultiple()
    {
      
        $this->validate([
            'photos.*' => 'image|max:1024', // 1MB Max
        ]);
 
        foreach ($photos as $photo) {
            $fileUrl = $photo->store('universe/'. $this->universe_id .'/'.'books/'.$this->book_id.'/pages', 's3-public');
            // $book = Book::find($this->book_id);
            //     if($book) {
            //         $book->book_image_path = $fileUrl;
            //         $book->save();
            //     } else {
            //         abort(500, 'Something went wrong. Our developers are on it!');
            //     }
        }
        return redirect()->route('books.create', ['step' => 4, 'universe_id' => $this->universe_id, 'book_id' => $this->book_id]);
    }

    public function render()
    {
        return view('livewire.book-pages-upload');
    }
}


<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\Book;
use Livewire\WithFileUploads;

class BookCoverUpload extends Component
{
    use WithFileUploads;
    public $photo;
    public $universe_id;
    public $book_id;


    public function mount($universe_id, $book_id)
    {
        $this->universe_id = $universe_id;
        $this->book_id = $book_id;
    }

    public function saveBookCover()
    {
        $this->validate([
            'photo' => 'image|max:10024', // 1MB Max
        ]);
 
        
        $book = Book::find($this->book_id);
            $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/'.'books/'.$this->book_id.'/cover', 's3-public');
            if($book) {
                $book->book_image_path = $fileUrl;
                $book->save();
            } else {
                abort(500, 'Something went wrong!');
            }
        // return redirect()->route('books.create', ['step' => 3, 'universe_id' => $this->universe_id, 'book_id' => $this->book_id]);
        return redirect()->route('books.index', $this->universe_id);
    }
    public function render()
    {
        return view('livewire.book-cover-upload');
    }
}

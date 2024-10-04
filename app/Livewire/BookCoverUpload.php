<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\Book;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class BookCoverUpload extends Component
{
    use WithFileUploads;
    public $photo;
    public $universe_id;
    public $book_id;
    public $logo;
    public $type;

    public function mount($universe_id, $book_id, $logo, $type)
    {
        $this->universe_id = $universe_id;
        $this->book_id = $book_id;
        $this->logo = $logo;
        $this->type = $type;
 
    }

    public function saveBookCover()
    {
        $this->validate([
            'photo' => 'image|max:10000000', // 1MB Max
        ]);
 
        
        $book = Book::find($this->book_id);
            $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/'.'books/'.$this->book_id.'/cover', 's3-public');
            if($book) {
                // if($book->book_image_path) {
                //     if (Storage::disk('s3-public')->exists($book->book_image_path)) {
                //         Storage::disk('s3-public')->delete($book->book_image_path);
                //     }
                // }
                $book->book_image_path = $fileUrl;
                
                $book->save();
                // dd(Storage::disk('s3-public')->exists($fileUrl), $fileUrl, $book->book_image_path);
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

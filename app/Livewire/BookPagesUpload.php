<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\Book;
use App\Http\Controllers\UploadController;

class BookPagesUpload extends Component
{
    use WithFileUploads;

    public $photos = [];

    public function uploadMultiple()
    {
        dd('hi');
        $this->validate([
            'photos.*' => 'image|max:1024', // 1MB Max
        ]);
 
        foreach ($this->photos as $photo) {
            $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/'.'books/'.$this->book_id.'/pages', 's3-public');
            // $book = Book::find($this->book_id);
            //     if($book) {
            //         $book->book_image_path = $fileUrl;
            //         $book->save();
            //     } else {
            //         abort(500, 'Something went wrong. Our developers are on it!');
            //     }
        }
        return redirect()->route('universe.create', ['step' => 3, 'universe_id' => $this->universe_id, 'book_id' => $this->book_id]);
    }

    public function render()
    {
        return view('livewire.book-pages-upload');
    }
}

<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookCoverUpload extends Component
{
    use WithFileUploads;

    public $photo;
    public $universe_id;
    public $book_id;
    public $logo;
    public $type;
    public $current;

    public function mount(
        $universe_id,
        $book_id,
        $current = null,
        $logo = null,
        $type = null
    ) {
        $this->universe_id = $universe_id;
        $this->book_id = $book_id;
        $this->logo = $logo;
        $this->type = $type;
        $this->current = $current;
    }

    public function saveBookCover()
    {
        $this->validate(
            [
                'photo' => 'required|image|max:10240',
            ],
            [
                'photo.required' => 'Please upload a photo.',
                'photo.image' => 'The uploaded file must be an image.',
                'photo.max' => 'The image may not be larger than 10 MB.',
            ]
        );

        $book = Book::findOrFail($this->book_id);

        $fileUrl = $this->photo->store(
            'universe/' .
            $this->universe_id .
            '/books/' .
            $this->book_id .
            '/cover',
            's3-public'
        );

        $book->book_image_path = $fileUrl;
        $book->save();

        return redirect()->route('books.index', [
            'universe_id' => $this->universe_id,
        ]);
    }

    public function render()
    {
        return view('livewire.book-cover-upload');
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\Book;
use App\Http\Controllers\UploadController;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class IssuePagesUpload extends Component
{
    use WithFileUploads;

    public $photos = [];
    public $universe_id;
    public $book_id;
    public $issue_id;


    public function mount($universe_id, $book_id, $issue_id)
    {
        $this->universe_id = $universe_id;
        $this->book_id = $book_id;
        $this->issue_id = $issue_id;
    }


    public function saveIssuePage()
    {
      
        $this->validate([
            'photos.*' => 'image|max:10000000', // 1MB Max
        ]);
 
        foreach ($photos as $photo) {
            $issue =Issue::find($this->issue_id);

            $duplicate_file = 'universe/'. $this->universe_id .'/'.'books/'.$this->book_id.'issues/'.$this->issue_id.'/pages';
            
            $s3 = Storage::disk('s3-public');
             //check if filename like that already exists
             if (Storage::disk('s3-public')->exists($duplicate_file)) {
                 Storage::disk('s3-public')->delete($duplicate_file);
                 //Delete file in DB
                 
             }


             $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/'.'books/'.$this->book_id.'issues/'.$this->issue_id.'/pages', 's3-public');
            
             
             //save in DB
            $issue_page = new IssuePage;
                if($issue) {
                   $issue_page->issue_id = $issue->id;
                   $issue_page->issue_page_url = $fileUrl;
                   $issue_page->save();
                } else {
                    abort(500, 'Something went wrong!!');
                }
        }
        return redirect()->route('books.create', ['step' => 4, 'universe_id' => $this->universe_id, 'book_id' => $this->book_id]);
    }

    public function render()
    {
        return view('livewire.book-pages-upload');
    }
}


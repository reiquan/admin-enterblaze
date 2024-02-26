<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\IssuePage;
use App\Models\Book;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class IssuePageSingleUpload extends Component
{
    use WithFileUploads;
    public $photo;
    public $universe_id;
    public $book_id;
    public $issue_id;
    public $issue_page_id;


    public function mount($universe_id, $book_id, $issue_id, $issue_page_id)
    {
        $this->universe_id = $universe_id;
        $this->book_id = $book_id;
        $this->issue_id = $issue_id;
        $this->issue_page_id = $issue_page_id;
    }

    public function saveIssuePage()
    {

 
        
        $issue_page = IssuePage::find($this->issue_page_id);

          //replace page
      if($issue_page){
        if (Storage::disk('s3-public')->exists($issue_page->issue_page_url)) {
            Storage::disk('s3-public')->delete($issue_page->issue_page_url);
        }
      }

        $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/'.'books/'.$this->book_id.'issues/'.$this->issue_id.'/pages', 's3-public');
        if($issue_page) {

            $issue_page->issue_page_url = $fileUrl;
            $issue_page->save();
        } else {
            abort(500, 'Something went wrong!');
        }
        // return redirect()->route('books.create', ['step' => 3, 'universe_id' => $this->universe_id, 'book_id' => $this->book_id]);
        return redirect()->route('issues.show', ['universe_id' => $this->universe_id, 'book_id' => $this->book_id, 'issue_id' => $this->issue_id]);
    }

    public function render()
    {
        return view('livewire.issue-page-single-upload');
    }
}

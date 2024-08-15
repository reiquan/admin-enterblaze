<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\Book;
use App\Models\Issue;
use Livewire\WithFileUploads;

class IssueCoversUpload extends Component
{
    use WithFileUploads;
    public $photo;
    public $universe_id;
    public $book_id;
    public $issue_id;


    public function mount($universe_id, $book_id, $issue_id)
    {
        $this->universe_id = $universe_id;
        $this->book_id = $book_id;
        $this->issue_id = $issue_id;
    }

    public function saveIssueCover()
    {
        $this->validate([
            'photo' => 'image|max:10000000', // 1MB Max
        ]);
 
        
        $issue = Issue::find($this->issue_id);
            $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/'.'books/'.$this->book_id.'/'.'issues/'.$this->issue_id.'/covers', 's3-public');

            if($issue) {
                $issue->issue_image_cover = $fileUrl;
                $issue->save();
            } else {
                abort(500, 'Something went wrong!');
            }
        return redirect()->route('issues.create', ['step' => 3, 'universe_id' => $this->universe_id, 'book_id' => $this->book_id, 'issue_id' => $this->issue_id]);
    }
    public function render()
    {
        return view('livewire.issue-covers-upload');
    }
}
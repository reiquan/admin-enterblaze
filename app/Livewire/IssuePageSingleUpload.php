<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\IssuePage;
use App\Models\Issue;
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
    public $action;


    public function mount($universe_id, $book_id, $issue_id, $issue_page_id, $action = null)
    {
        $this->universe_id = $universe_id;
        $this->book_id = $book_id;
        $this->issue_id = $issue_id;
        $this->issue_page_id = $issue_page_id;
        $this->action = $action;

    }

    public function saveIssuePage()
    {

 
        
        $issue_page = IssuePage::find($this->issue_page_id);
        $assign_page_number = IssuePage::where('issue_id', $this->issue_id)
                                            ->whereNotNull('issue_page_number')
                                            ->orderBy('issue_page_number')
                                            ->get();
            


          //replace page
      if($issue_page){
        if (Storage::disk('s3-public')->exists($issue_page->issue_page_url)) {
            Storage::disk('s3-public')->delete($issue_page->issue_page_url);
        }
        $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/'.'books/'.$this->book_id.'issues/'.$this->issue_id.'/pages', 's3-public');
        $issue_page->issue_page_url = $fileUrl;
        if($assign_page_number->isNotEmpty()) {
            $max = $assign_page_number->max();
            $issue_page->issue_page_number = intval($max->issue_page_number) + 1;
            $issue_page->save();
            $count = 0;
            foreach($issue_page->issue->pages as $page){
                $p = IssuePage::find($page->id);
            
                $p->issue_page_number = $count += 1;
                $p->save();

            }
        } else {
            $issue_page->issue_page_number = 1;
            $issue_page->save();
        }
        
        return redirect()->route('issues.show', ['universe_id' => $this->universe_id, 'book_id' => $this->book_id, 'issue_id' => $this->issue_id]);
    
       
      }

        
 

        $issue = Issue::find($this->issue_id);

        $issue_page = new IssuePage;
        $issue_page->issue_id = $this->issue_id;
        $issue_page->issue_page_url = $fileUrl;


        return redirect()->route('issues.show', ['universe_id' => $this->universe_id, 'book_id' => $this->book_id, 'issue_id' => $this->issue_id]);
    
      
    }

    public function render()
    {
        return view('livewire.issue-page-single-upload');
    }
}

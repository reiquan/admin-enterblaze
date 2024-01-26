<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class BannerUpload extends Component
{
    use WithFileUploads;
 
    public $photo;
    public $universe_id;

    public function mount($universe_id)
    {
        $this->universe_id = $universe_id;
    }
  

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);
 
        $this->photo->store('universe/'. $this->universe_id .'/images/banner', 's3-public');
        return redirect()->route('universe.create', ['step' => 4, 'universe_id' => $this->universe_id]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileUpload extends Component
{
    use WithFileUploads;
    public $photo;
    public $universe_id;


    public function mount($universe_id)
    {
        $this->universe_id = $universe_id;
    }

    public function saveProfile()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);
 
        $this->photo->store('universe/'. $this->universe_id .'/images/profile', 's3-public');
        return redirect()->route('universe.index', ['step' => 3, 'universe_id' => $this->universe_id]);
    }
}

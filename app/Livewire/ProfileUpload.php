<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Universe;

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
 
        $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/images/profile', 's3-public');
        $universe = Universe::find($this->universe_id);
            if($universe) {
                $universe->universe_logo = $fileUrl;
                $universe->save();
            } else {
                abort(500, 'Something went wrong. Our developers are on it!');
            }
        return redirect()->route('universe.create', ['step' => 3, 'universe_id' => $this->universe_id]);
    }
}

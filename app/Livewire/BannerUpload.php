<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Universe;

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
 
        $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/images/banner', 's3-public');
        $universe = Universe::find($this->universe_id);
        if($universe) {
            $universe->universe_image_url = $fileUrl;
            $universe->save();
        } else {
            abort(500, 'Something went wrong. Our developers are on it!');
        }
        return redirect()->route('universe.index', ['universe_name' => $universe->universe_name]);
    }
}

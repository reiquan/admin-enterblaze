<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImagesService extends Component
{
    use WithFileUploads;
 
    public $photos = [];

 

    public function saveMultiple()
    {
        $this->validate([
            'photos.*' => 'image|max:10000000', // 1MB Max
        ]);
 
        foreach ($this->photos as $photo) {
            $photo->store('photos', 's3-public');
        }
    }

    public function uploadMultiple()
    {
       
        $this->validate([
            'photos.*' => 'image|max:10000000', // 1MB Max
        ]);
 
        foreach ($this->photos as $photo) {
            $photo->store('photos', 's3-public');
        }
    }

    public function render()
    {
        return view('livewire.images-service');
    }


}

<?php

namespace App\Http\Controllers;
use Livewire\WithFileUploads;
use Livewire\Component;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    use WithFileUploads;
 
    public $photos = [];

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);
 
        $this->photo->store('photos');
    }

    public function saveMultiple()
    {
        $this->validate([
            'photos.*' => 'image|max:1024', // 1MB Max
        ]);
 
        foreach ($this->photos as $photo) {
            $photo->store('photos');
        }
    }
}

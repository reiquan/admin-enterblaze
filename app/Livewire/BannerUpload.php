<?php

namespace App\Livewire;

use App\Models\Universe;
use Livewire\Component;
use Livewire\WithFileUploads;

class BannerUpload extends Component
{
    use WithFileUploads;

    public $photo;
    public $universe_id;
    public $logo;
    public $type;

    public function mount($universe_id, $logo, $type)
    {
        $this->universe_id = $universe_id;
        $this->logo = $logo;
        $this->type = $type;
    }

    public function save()
    {
        $this->validate(
            [
                'photo' => 'required|image|max:10240',
            ],
            [
                'photo.required' => 'Please upload a photo.',
                'photo.image' => 'The uploaded file must be an image.',
                'photo.max' => 'The image may not be larger than 10 MB.',
            ]
        );

        $universe = Universe::findOrFail($this->universe_id);
                    // if($universe->universe_image_url) {
            //     if (Storage::disk('s3-public')->exists($universe->universe_image_url)) {
            //         Storage::disk('s3-public')->delete($universe->universe_image_url);
            //     }
            // }

        $fileUrl = $this->photo->store(
            'universe/' . $this->universe_id . '/images/banner',
            's3-public'
        );

        $universe->universe_image_url = $fileUrl;
        $universe->save();

        return redirect()->route('universe.index', [
            'universe_id' => $universe->id,
        ]);
    }
}
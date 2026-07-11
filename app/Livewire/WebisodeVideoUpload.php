<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\Webisode;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class WebisodeVideoUpload extends Component
{
    use WithFileUploads;
    public $photo;
    public $universe_id;
    public $webisode_id;
    public $webisode_video_id;
    public $logo;
    public $type;
    public $field;
    public $current;

    public function mount($universe_id, $webisode_id,$webisode_video_id, $current, $logo, $field, $type)
    {
        $this->universe_id = $universe_id;
        $this->webisode_id = $webisode_id;
        $this->webisode_video_id = $webisode_video_id;
        $this->logo = $logo;
        $this->type = $type;
        $this->field = $field;
        $this->current = $current;
 
    }

    public function saveWebisodeVideo()
    {
        $this->validate([
            'photo' => 'image|max:10000000', // 1MB Max
        ]);

        
        $webisode_video = WebisodeVideo::find($this->webisode_video_id);
            $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/'.'webisodes/'.$this->webisode_id.'/webisode-videos/'.$this->webisode_video_id, 's3-public');
            if($webisode_video) {
                // if($webisode_video->webisode_image_path) {
                //     if (Storage::disk('s3-public')->exists($webisode_video->webisode_image_path)) {
                //         Storage::disk('s3-public')->delete($webisode_video->webisode_image_path);
                //     }
                // }
                    $webisode_video->video_path = $fileUrl;
        
               
                
                $webisode_video->save();
                // dd(Storage::disk('s3-public')->exists($fileUrl), $fileUrl, $webisode_video->webisode_image_path);
            } else {
                abort(500, 'Something went wrong!');
            }
        // return redirect()->route('webisodes.create', ['step' => 3, 'universe_id' => $this->universe_id, 'webisode_id' => $this->webisode_id]);
        // return redirect()->route('card-series.index', $this->universe_id);
    }
    public function render()
    {
        return view('livewire.webisode-video-upload');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EventImageUpload extends Component
{
    use WithFileUploads;
    public $photo;
    public $event_id;
    public $logo;
    public $type;


    public function mount($event_id, $logo, $type)
    {
        $this->event_id = $event_id;
        $this->logo = $logo;
        $this->type = $type;
    }

    public function saveEventImage(Request $request)
    {

        if($this->photo){
            $this->validate([
                'photo' => 'image|max:1024', // 1MB Max
            ]);
    
            $fileUrl = $this->photo->store('events/'. $this->event_id .'/images', 's3-public');
            $event = Event::find($this->event_id);
                if($event) {
                //    if($event->event_logo) {
                //     if (Storage::disk('s3-public')->exists($event->event_logo)) {
                //         Storage::disk('s3-public')->delete($event->event_logo);
                //     }
                //    }
                    $event->event_promo_image = $fileUrl;
                    $event->save();
                } else {
                    abort(500, 'Something went wrong. Our developers are on it!');
                }
                if(isset($this->type) && $this->type == 'edit'){
                    return redirect()->route('events.index', ['event' => $this->event_id]);
                } else {
                    return redirect()->route('events.index', ['event' => $this->event_id]);
                }
               
        }
        if(isset($this->type) && $this->type == 'edit'){
            return redirect()->route('events.index', ['event' => $this->event_id]);
        } else {
            return redirect()->route('events.index', ['event' => $this->event_id]);
        }
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\CardSeries;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CardUpload extends Component
{
    use WithFileUploads;
    public $photo;
    public $universe_id;
    public $card_series_id;
    public $logo;
    public $type;
    public $field;
    public $current;

    public function mount($universe_id, $card_series_id, $current, $logo, $field, $type)
    {
        $this->universe_id = $universe_id;
        $this->card_series_id = $card_series_id;
        $this->logo = $logo;
        $this->type = $type;
        $this->field = $field;
        $this->current = $current;
 
    }

    public function saveCardSeries()
    {
        $this->validate([
            'photo' => 'image|max:10000000', // 1MB Max
        ]);

        
        $card_series = CardSeries::find($this->card_series_id);
            $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/'.'card-series/'.$this->card_series_id, 's3-public');
            if($card_series) {
                // if($card_series->card_series_image_path) {
                //     if (Storage::disk('s3-public')->exists($card_series->card_series_image_path)) {
                //         Storage::disk('s3-public')->delete($card_series->card_series_image_path);
                //     }
                // }
                if($this->field == 'card_series_image_front'){
                    $card_series->card_series_image_front = $fileUrl;
                } else {
                    $card_series->card_series_image_back = $fileUrl;
                }
               
                
                $card_series->save();
                // dd(Storage::disk('s3-public')->exists($fileUrl), $fileUrl, $card_series->card_series_image_path);
            } else {
                abort(500, 'Something went wrong!');
            }
        // return redirect()->route('card_seriess.create', ['step' => 3, 'universe_id' => $this->universe_id, 'card_series_id' => $this->card_series_id]);
        // return redirect()->route('card-series.index', $this->universe_id);
    }
    public function render()
    {
        return view('livewire.card-upload');
    }
}

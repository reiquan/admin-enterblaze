<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Universe;
use App\Models\Card;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CardUpload extends Component
{
    use WithFileUploads;
    public $photo;
    public $universe_id;
    public $card_series_id;
    public $card_id;
    public $logo;
    public $type;
    public $field;
    public $current;

    public function mount($universe_id, $card_series_id, $card_id, $current, $logo, $field, $type)
    {
        $this->universe_id = $universe_id;
        $this->card_series_id = $card_series_id;
        $this->card_id = $card_id;
        $this->logo = $logo;
        $this->type = $type;
        $this->field = $field;
        $this->current = $current;
 
    }

    public function saveCard()
    {
        if (!$this->photo) {
            $this->addError('photo', 'Please select an image first.');
            return;
        }
    
        if (!$this->universe_id || !$this->card_id) {
            $this->addError('photo', 'Missing universe or card ID.');
            return;
        }
    
    
        $this->validate([
            'photo' => 'image|max:10000000', // 1MB Max
        ]);

        
        $card = Card::find($this->card_id);

            $fileUrl = $this->photo->store('universe/'. $this->universe_id .'/'.'card-series/'.$this->card_series_id.'/cards/'.$this->card_id, 's3-public');
            if($card) {


                if($this->field == 'card_image_one'){
                    $card->card_image_one = $fileUrl;
                } else {
                    $card->card_image_two = $fileUrl;
                }
               
                
                $card->save();
             
            } else {
                abort(500, 'Something went wrong!');
            }
    
    }
    public function render()
    {
        return view('livewire.card-upload');
    }
}

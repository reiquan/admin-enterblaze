<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BookController;
use App\Models\Universe;
use App\Models\Issue;
use App\Models\Card;
use App\Models\CardCharacter;
use App\Models\IssuePage;
use App\Models\Book;
use App\Models\CardEra;
use App\Models\CardType;
use App\Models\CardFaction;
use App\Models\CardTier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;
use Validator;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(REQUEST $request)
    {
        //

        $cards = Card::where('card_series_id', $request->card_series_id)->get();
       
        $universe = Universe::find($request->universe_id);

        return view('universe/card/index', compact('cards', 'universe'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(REQUEST $request)
    {
        //
       
        $step = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;
    
        $card_series_id = isset($_REQUEST['card_series_id']) ? $_REQUEST['card_series_id'] : '';
        $universe = Universe::find($request->universe_id);
        $card_id = isset($_REQUEST['card_id']) ? $_REQUEST['card_id'] : '';
        $card = isset($_REQUEST['card']) ? $_REQUEST['card'] : '';
        $eras = CardEra::all();
        $card_types = CardType::all();
        $card_tiers = CardTier::all();
        $card_factions = CardFaction::where('card_faction_universe_id', $universe->id)->get();
        return view('universe/card-series/cards/create', compact('step', 'universe','card_factions', 'card_series_id', 'card_id', 'card', 'eras', 'card_types', 'card_tiers'));
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
          //validate info
          $card = isset($request->card_id) ? Card::find($request->card_id) : new Card;
        //save info
            if(isset($request->step) and $request->step == 1){
                if($request->step == 1){
                    $request->validate([
                        'card_name' => ['required'],
                        'card_price' => ['required'],
                        'card_published_at' => ['required'],
                        'card_tier_id' => ['required'],
                        'card_type_id' => ['required'],
                        'card_bio' => ['required'],
                        'card_rarity' => ['required'],
        
                        
                    ]);
                  }
               
                //save book
            
                        $card->card_name = $request->card_name;
                        $card->card_series_id = $request->card_series_id;
                        $card->card_slug = preg_replace('/[^a-zA-Z0-9\s]/', '', $request->card_name);
                        $card->card_era_id = $request->card_era_id;
                        $card->card_character_id = $request->card_character_id ?? null;
                        $card->card_locaton_id = $request->card_locaton_id ?? null;
                        $card->card_faction_id = $request->card_faction_id ?? null;
                        $card->card_type_id = $request->card_type_id;
                        $card->card_rarity = $request->card_rarity;
                        $card->card_tier_id = $request->card_tier_id;
                        $card->card_price = $request->card_price;
                        $card->card_bio = $request->card_bio;
                        $card->card_is_active = null;
                    
                    $card->save();

            }

           
            $universe_id = $request->universe_id;
            $card_id = $card->id ?? $request->card_id;
            $card_series_id = $card->card_series_id;
            $step = $request->type == 'edit' ? $request->step : $request->step += 1;
         
            if($request->step == 3){
              
                $card_type = CardType::where('id',$card->card_type_id )->first();
             
                $card_type_form = strtolower($card_type->card_type_name).'-form';
                $card_tier_skill_points = $card->tier->card_tier_skill_points;
    

                if(isset($request->type) && $request->type == 'edit'){
                    
                    return view('universe.card-series.cards.edit', compact('step', 'universe_id', 'card', 'card_type', 'card_type_form', 'card_tier_skill_points'));
                } else {
                   
                    return view('universe.card-series.cards.create', compact('step', 'universe_id','card_series_id', 'card_id', 'card','card_type', 'card_type_form', 'card_tier_skill_points'));
                }

            } 
                
                if(isset($request->type) && $request->type == 'edit'){
                    return view('universe.card-series.cards.edit', compact('step', 'universe_id', 'card'));
                } else {
                    return view('universe.card-series.cards.create', compact('step', 'universe_id','card_series_id', 'card_id', 'card'));
                }

            
          ;
    }

  /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        //
        $card = Card::find($request->c_id);
        $cards = $card->cards;
    
        // dd($issues->toArray());
       
        return view('universe/card/show', compact('card', 'cards'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $card = Card::find($request->card_id);
       
        $step=isset($request->step) ? $request->step : 1;
        $universe = $card->universe;
        $type='edit';
        $eras = CardEra::all();
        $formattedDate = Carbon::parse($card->card_published_at)->format('Y-m-d');
        $books = Book::where('book_universe_id', $universe->id)->get();
        return view('universe/card/edit', compact('card', 'step','eras','books', 'universe', 'formattedDate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
       
        $request->validate([
            'card_character_name' => ['required'],
            'card_character_alias' => ['required'],
            'card_character_race' => ['required'],
            'card_character_gender' => ['required'],
            'card_character_age' => ['required'],
            'card_character_occupation' => ['required'],      
        ]);

        $cardCharacter = isset($request->card_character_id) ? CardCharacter::find($request->card_character_id) : new CardCharacter;

        $cardCharacter->card_character_name = $request->card_character_name;
            $cardCharacter->card_character_universe_id = $request->card_character_universe_id;
            $cardCharacter->card_character_alias = $request->card_character_alias;
            $cardCharacter->card_character_race = $request->card_character_race ?? null;
            $cardCharacter->card_character_age = $request->card_character_age ?? null;
            $cardCharacter->card_character_gender = $request->card_character_gender ?? null;
            $cardCharacter->card_character_affiliation = $request->card_character_affiliation ?? null;
            $cardCharacter->card_character_occupation = $request->card_character_occupation;
            $cardCharacter->card_character_abilities = json_encode($request->card_character_abilities);
            $cardCharacter->card_character_physical = $request->card_character_physical;
            $cardCharacter->card_character_bio = $request->card_character_bio;
            $cardCharacter->card_character_mental = $request->card_character_mental;
            $cardCharacter->card_character_spiritual = $request->card_character_spiritual;
        
        $cardCharacter->save();

        $card = Card::find($request->card_id);
        $card->card_character_id = $cardCharacter->id;
        $card->save();

        $universe_id = $request->card_character_universe_id;
        $card_id = $card->id ?? $request->card_id;
        $card_series_id = $card->card_series_id;
        $step = $request->type == 'edit' ? $request->step : $request->step += 1;
        $card_type = CardType::where('id',$card->card_type_id )->first();
             
        $card_type_form ='skill-form';
        $card_tier_skill_points = $card->tier->card_tier_skill_points;

        if(isset($request->type) && $request->type == 'edit'){
                    
            return view('universe.card-series.cards.edit', compact('step', 'universe_id', 'card', 'card_type', 'card_type_form', 'card_tier_skill_points'));
        } else {
           
            return view('universe.card-series.cards.create', compact('step', 'universe_id','card_series_id', 'card_id', 'card','card_type', 'card_type_form', 'card_tier_skill_points'));
        }
    }

         /**
     * Show the form for publishing the specified resource.
     */
    public function publish(Request $request, string $id)
    {
        //
        $request->validate([
            'card_id' => ['required']
        ]);
        $card = Card::find($request->card_id);
        if($request->action == 'publish'){
            $card->card_is_active = 1;
            $card->save();
        } else {
            $card->card_is_active = 0;
            $card->save();
        }
       
        return redirect()->route('card.index', $card->card_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //  dd($request->all());
         $request->validate([
            'card_id' => ['required'],
                 
        ]);
        $card = Card::find($request->card_id);
        if($card->card_image_front) {
            if (Storage::disk('s3-public')->exists($card->card_image_front)) {
                Storage::disk('s3-public')->delete($card->card_image_front);
            }
        }
        if($card->card_image_back) {
            if (Storage::disk('s3-public')->exists($card->card_image_back)) {
                Storage::disk('s3-public')->delete($card->card_image_back);
            }
        }
        $card->delete();
         return response()->json(['success' => 'Card Series deleted successfully.']);
    }

        /**
     * Display a listing of the resource.
     */
    public function finish(REQUEST $request)
    {
        //

        $card = Card::find($request->card_id);
        $card_id = $card->id;
        // dd($card->toArray());
        $universe = Universe::find($card->card_id);
        $universe_id = $card->card_id;

        $step = 3;

       if($request->type == 'edit'){
        return view('universe.card.edit', compact('step', 'universe_id', 'card_id', 'card'));
       } else {
        return view('universe.card.create', compact('step', 'universe_id', 'card_id', 'card'));
       }
    }

}

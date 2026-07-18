<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BookController;
use App\Models\Universe;
use App\Models\Issue;
use App\Models\Card;
use App\Models\CardCharacter;
use App\Models\CardLocation;
use App\Models\CardSkill;
use App\Models\CardSkillType;
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

        $card_series_id = $request->card_series_id;
       
        $universe = Universe::find($request->universe_id);

        return view('universe/card-series/cards/index', compact('cards', 'card_series_id','universe'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update(REQUEST $request)
    {
     
        if(isset($request->type) && $request->type == 'default'){
            $card = Card::find($request->card_id);
            $card->card_tags = $request->card_tags;
            $card->save();
            
            $step= 5;
            $universe_id = $request->card_location_universe_id;
            $card_id = $card->id ?? $request->card_id;
            $card_series_id = $card->card_series_id;
            $card_type = CardType::where('id',$card->card_type_id )->first();
                
            $card_type_form ='finish';
            $card_tier_skill_points = $card->tier->card_tier_skill_points;


            $card_skills=null;
            $bonuses = json_decode($request->card_tags);
         
            $card_skill_types = CardSkillType::all();
        
           
            return view('universe.card-series.cards.finish', compact('step', 'universe_id','card_series_id', 'card_id', 'card','card_type', 'card_type_form', 'card_tier_skill_points', 'card_skills', 'bonuses'));

        }
        $card_type = null;
                
        $card_type_form = null;
        $card_tier_skill_points = null;
        $step = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;

        $card_series_id = isset($_REQUEST['card_series_id']) ? $_REQUEST['card_series_id'] : '';

        $universe = Universe::find($request->universe_id);
        $card_id = isset($_REQUEST['card_id']) ? $_REQUEST['card_id'] : '';

        $card = isset($_REQUEST['card_id']) ? Card::find($_REQUEST['card_id']) : '';
     
        $eras = CardEra::all();
        $card_types = CardType::all();
        $card_tiers = CardTier::all();
        $card_factions = CardFaction::where('card_faction_universe_id', $universe->id)->get();
        $formattedDate = $card_id ? Carbon::parse($card->card_published_at)->format('Y-m-d') : null;
        $cardSkills = $card ? $card->skills->toArray() : null;
        $card_skill_types = CardSkillType::all();

        if($request->step == 3){
            $card_type = CardType::where('id',$card->card_type_id )->first();
             
            $card_type_form = strtolower($card_type->card_type_name).'-form';
            $card_tier_skill_points = $card->tier->card_tier_skill_points;
        }

        if($request->step == 4){

            $card_type = CardType::where('id',$card->card_type_id )->first();

            $card_type_form = strtolower('skill-form');

            $card_tier_skill_points = $card->tier->card_tier_skill_points;

        }

        return view('universe/card-series/cards/create', compact('step', 'card_skill_types', 'cardSkills','formattedDate','card_type_form','card_type','card_tier_skill_points','universe','card_factions', 'card_series_id', 'card_id', 'card', 'eras', 'card_types', 'card_tiers'));
 
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
                        $card->card_location_id = $request->card_location_id ?? null;
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
                // dd($card_type_form);
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
    public function show(Request $request)
    {
        
        
        $card = Card::find($request->c_id);
        $card_series_id = $card->series->id;
        $universe_id = $card->series->universe->id;
        $card->load([
            'series',
            'era',
            'type',
            'tier',
            'character',
            'skills',
        ]);
   
    
        // dd($issues->toArray());
       
        return view('universe.card-series.cards.show', compact(
            'card',
            'universe_id',
            'card_series_id'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $card = Card::find($request->card_id ?? $request->c_id);
        $card_id = $card->id;
        $step=isset($request->step) ? $request->step : 1;
        $universe = $card->series->universe;
        $card_series_id = $card->series->id;
        $card_types = CardType::all();
        $card_factions = CardFaction::all();
        $card_tiers = CardTier::all();
        $type='edit';
        $eras = CardEra::all();
        $formattedDate = Carbon::parse($card->card_published_at)->format('Y-m-d');
        $books = Book::where('book_universe_id', $universe->id)->get();

        return view('universe/card-series/cards/create', compact('card','card_tiers','card_types','card_factions','card_id','card_series_id', 'step','eras','books', 'universe', 'formattedDate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCardTier(Request $request)
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
        $step = $request->step && $request->step == 3 ? $request->step += 1 : $request->step;
        $card_type = CardType::where('id',$card->card_type_id )->first();
             
        $card_type_form ='skill-form';
        $card_tier_skill_points = $card->tier->card_tier_skill_points;

        if($request->step == 4){
            $cardSkills= isset($request->card_character_id) ? CardSkill::where('card_skill_character_id',$request->card_character_id)->limit(2)->get() : new CardSkill;
          
            $card_skill_types = CardSkillType::all();
            $card_types = CardType::all();

            return view('universe.card-series.cards.create', compact('step', 'card_types','cardSkills', 'card_skill_types','universe_id','card_series_id', 'card_id', 'card','card_type', 'card_type_form', 'card_tier_skill_points'));

        }
        
           
            return view('universe.card-series.cards.create', compact('step', 'universe_id','card_series_id', 'card_id', 'card','card_type', 'card_type_form', 'card_tier_skill_points'));
    }

    public function updateCardSkill(Request $request)
    {
        $card = Card::find($request->card_id);
        $bonuses = null;

        if(isset($request->type) && $request->type){ 
            
            
           
            
            if(isset($card->location->card_location_bonuses)){
                $bonuses = json_decode($card->location->card_location_bonuses) ?? "[]";

            } else {
                $bonuses = json_decode($card->card_tags) ?? "[]";
            }
            
     
            $universe_id = $request->universe_id;
            $card_id = $card->id ?? $request->card_id;
            $card_series_id = $card->card_series_id;
            $step = $request->step && $request->step == 4 ? $request->step += 1 : $request->step;
            $card_type = CardType::where('id',$card->card_type_id )->first();
                 
            $card_type_form ='finish';
            $card_tier_skill_points = $card->tier->card_tier_skill_points;
                // dd($step);
        
            $card_skills= null;
            $card_skill_types = CardSkillType::all();
                

                return view('universe.card-series.cards.finish', compact('step','bonuses', 'card_skills', 'card_skill_types','universe_id','card_series_id', 'card_id', 'card','card_type', 'card_type_form', 'card_tier_skill_points'));
    
   

        } else {
            //  dd($request->all());
          
    

          $cardSkillOne = isset($request->card_skill_id_one) ? CardSkill::findOrNew($request->card_skill_id_one) : new CardSkill;
          $cardSkillTwo = isset($request->card_skill_id_two) ? CardSkill::findOrNew($request->card_skill_id_two) : new CardSkill;
  
  
              $cardSkillOne->card_skill_name = $request->skills[0]['card_skill_name']  ?? null;
              $cardSkillOne->card_skill_condition = $request->skills[0]['card_skill_condition']  ?? null;
              $cardSkillOne->card_skill_element = $request->skills[0]['card_skill_element']  ?? null;
              $cardSkillOne->card_skill_energy_cost = $request->skills[0]['card_skill_energy_cost'] ?? null;
              $cardSkillOne->card_skill_cooldown = $request->skills[0]['card_skill_cooldown']  ?? null;
              $cardSkillOne->card_skill_range = $request->skills[0]['card_skill_range']  ?? null;
              $cardSkillOne->card_skill_description = $request->skills[0]['card_skill_description']  ?? null;
              $cardSkillOne->card_skill_range = $request->skills[0]['card_skill_range']  ?? null;
              $cardSkillOne->card_skill_card_id = $request->card_id  ?? null;
              $cardTypeOne = CardType::find($request->skills[0]['card_skill_type_id']);
              $cardSkillOne->card_skill_type_id = $cardTypeOne->id ?? null;
              $cardSkillOne->card_skill_character_id = $request->card_character_id ?? null;
          
          $cardSkillOne->save();
  
          if(isset($request->skills[1])){
                  $cardSkillTwo->card_skill_name = $request->skills[1]['card_skill_name']  ?? null;
                  $cardSkillTwo->card_skill_condition = $request->skills[1]['card_skill_condition']  ?? null;
                  $cardSkillTwo->card_skill_element = $request->skills[1]['card_skill_element']  ?? null;
                  $cardSkillTwo->card_skill_energy_cost = $request->skills[1]['card_skill_energy_cost'] ?? null;
                  $cardSkillTwo->card_skill_cooldown = $request->skills[1]['card_skill_cooldown']  ?? null;
                  $cardSkillTwo->card_skill_range = $request->skills[1]['card_skill_range']  ?? null;
                  $cardSkillTwo->card_skill_description = $request->skills[1]['card_skill_description']  ?? null;
                  $cardSkillTwo->card_skill_range = $request->skills[1]['card_skill_range']  ?? null;
                  $cardSkillTwo->card_skill_card_id = $request->card_id  ?? null;
                      $cardTypeTwo = CardType::find($request->skills[1]['card_skill_type_id']);
                  $cardSkillTwo->card_skill_type_id = $cardTypeTwo->id ?? null;
                  $cardSkillTwo->card_skill_character_id = $request->card_character_id ?? null;
          
              $cardSkillTwo->save();
          }
          $universe_id = $request->card_character_universe_id;
          $card_id = $card->id ?? $request->card_id;
          $card_series_id = $card->card_series_id;
          $step = $request->step && $request->step == 4 ? $request->step += 1 : $request->step;
          $card_type = CardType::where('id',$card->card_type_id )->first();
               
          $card_type_form ='finish';
          $card_tier_skill_points = $card->tier->card_tier_skill_points;
              // dd($step);
          if($request->step == 5){
              $card_skills= isset($request->card_character_id) ? CardSkill::where('card_skill_character_id',$request->card_character_id)->get() : new CardSkill;
              $card_skill_types = CardSkillType::all();
              
  
              return view('universe.card-series.cards.finish', compact('step', 'bonuses','card_skills', 'card_skill_types','universe_id','card_series_id', 'card_id', 'card','card_type', 'card_type_form', 'card_tier_skill_points'));
  
          }
          
             
              return view('universe.card-series.cards.create', compact('step', 'bonuses', 'universe_id','card_series_id', 'card_id', 'card','card_type', 'card_type_form', 'card_tier_skill_points'));
        }
       
    }

    public function updateCardLocation(Request $request)
    {
        
        // dd($request->all());
        $card = Card::find($request->card_id);
    // dd($card->toArray());

        $card_location = isset($request->location_id) ? CardLocation::findOrNew($request->location_id) : new CardLocation;


            $card_location->card_location_name = $request->card_location_name  ?? null;
            $card_location->card_location_environment = $request->card_location_environment  ?? null;
            $card_location->card_location_region = $request->card_location_region  ?? null;
            $card_location->card_location_universe_id = $request->card_location_universe_id ?? null;
            $card_location->card_location_bonuses = $request->card_location_bonuses;
        
        
        $card_location->save();
        $card->card_location_id = $card_location->id;
        $card->save();

        $universe_id = $request->card_location_universe_id;
        $card_id = $card->id ?? $request->card_id;
        $card_series_id = $card->card_series_id;
        $step = $request->step && $request->step == 4 ? $request->step += 1 : $request->step;
        $card_type = CardType::where('id',$card->card_type_id )->first();
             
        $card_type_form ='finish';
        $card_tier_skill_points = $card->tier->card_tier_skill_points;


            $card_skills=null;
            $bonuses = json_decode($request->card_location_bonuses);
         
            $card_skill_types = CardSkillType::all();
        
           
            return view('universe.card-series.cards.finish', compact('step', 'universe_id','card_series_id', 'card_id', 'card','card_type', 'card_type_form', 'card_tier_skill_points', 'card_skills', 'bonuses'));
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
       
        return redirect()->route('cards.index',['universe_id' => $card->series->universe->id, 'card_series_id' => $card->series->id]);
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
        return view('universe.card-series.cards.edit', compact('step', 'universe_id', 'card_id', 'card'));
       } else {
        return view('universe.card-series.cards.create', compact('step', 'universe_id', 'card_id', 'card'));
       }
    }

}

<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BookController;
use App\Models\Universe;
use App\Models\Issue;
use App\Models\Card;
use App\Services\BookService;
use App\Models\IssuePage;
use App\Models\Book;
use App\Models\CardEra;
use App\Models\CardType;
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
        return view('universe/card-series/cards/create', compact('step', 'universe', 'card_series_id', 'card_id', 'card', 'eras', 'card_types', 'card_tiers'));
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     dd($request->all());
          //validate info
          if($request->step == 1){
            $request->validate([
                'card_name' => ['required'],
                'card_subtitle' => ['required'],
                'card_published_at' => ['required'],
                'card_era_id' => ['required'],
                'card_description' => ['required'],
                
            ]);
          }
          $card = isset($request->card_id) ? Card::find($request->card_id) : new Card;
        //save info
            if(isset($request->step) and $request->step == 1){
               
                //save book
            
                        $card->card_name = $request->card_name;
                        $card->card_published_at = $request->card_published_at;
                        $card->card_slug_name = preg_replace('/[^a-zA-Z0-9\s]/', '', $request->card_slug_name);
                        $card->card_era_id = $request->card_era_id;
                        $card->card_price = $request->card_price;
                        $card->card_id = $request->universe_id;
                        $card->card_description = $request->card_description;
                        $card->card_is_active = $request->card_is_active;
                        if(isset($request->card_subtitle)){
                            $card->card_subtitle = $request->card_subtitle;
                        }
                        if(isset($request->card_book_id)){
                            $card->card_book_id = $request->card_book_id;
                        }
                    
                    $card->save();

            }

           
            //if request->step == 4
            if($request->step == 3){
        
                return view('card.index');
               

            } else {
                
     
                $step = $request->type == 'edit' ? $request->step : $request->step += 1;
                $universe_id = $request->universe_id;
                $card_id = $card->id ?? $request->card_id;
                

                
                if(isset($request->type) && $request->type == 'edit'){
                    return view('universe.card.edit', compact('step', 'universe_id', 'card'));
                } else {
                    return view('universe.card.create', compact('step', 'universe_id', 'card_id', 'card'));
                }

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
       
        $request->validate([
            'card_id' => ['required'],
            'universe_id' => ['required'],
                 
        ]);

        ////make sure file is present
            if(!empty($request->file)){

                $fileName = $request->file('file')->getClientOriginalName();
                $path = 'universe/'.$request->universe_id.'/'.'card/'.$request->card_id.'/images';
        
                $file = $request->file('file');
            
                $s3 = Storage::disk('s3-public');
                $s3->putFileAs($path.$request->issue_number, $file, $fileName);
            }

            $CardService = new CardService($request->universe_id);

            $page_submitted = $CardService->checkCard($path, $fileName);

            if($page_submitted){
                return response()->json(['Success' => 'Series Uploaded Succesfully']);
            } else {
                return response()->json(['Error' => 'Series was not uploaded']);
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

<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BookController;
use App\Models\Universe;
use App\Models\Issue;
use App\Models\CardSeries;
use App\Services\BookService;
use App\Models\IssuePage;
use App\Models\Book;
use App\Models\CardEra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;
use Validator;

class CardSeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(REQUEST $request)
    {
        //
        // dd($request->toArray());
        $card_series = CardSeries::where('card_series_universe_id', intval($request->universe_id))->get();
    
      
        $universe = Universe::find($request->universe_id);

        return view('universe/card-series/index', compact('card_series', 'universe'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($universe_id)
    {
        //
        
        $step = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;
        $universe = Universe::find($universe_id);
        $universe_id = isset($_REQUEST['universe_id']) ? $_REQUEST['universe_id'] : '';
        $card_series_id = isset($_REQUEST['card_series_id']) ? $_REQUEST['card_series_id'] : '';
        $card_series = isset($_REQUEST['card_series']) ? $_REQUEST['card_series'] : '';
        $books = Book::where('book_universe_id', $universe_id)->get();
        $eras = CardEra::all();
        return view('universe/card-series/create', compact('step', 'universe', 'universe_id', 'card_series_id', 'card_series', 'eras', 'books'));
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          //validate info
          if($request->step == 1){
            $request->validate([
                'card_series_name' => ['required'],
                'card_series_subtitle' => ['required'],
                'card_series_published_at' => ['required'],
                'card_series_era_id' => ['required'],
                'card_series_description' => ['required'],
                'card_series_price' => ['required'],
                
            ]);
          }
          $card_series = isset($request->card_series_id) ? CardSeries::find($request->card_series_id) : new CardSeries;
        //save info
            if(isset($request->step) and $request->step == 1){
               
                //save book
            
                        $card_series->card_series_name = $request->card_series_name;
                        $card_series->card_series_published_at = $request->card_series_published_at;
                        $card_series->card_series_slug_name = preg_replace('/[^a-zA-Z0-9\s]/', '', $request->card_series_slug_name);
                        $card_series->card_series_era_id = $request->card_series_era_id;
                        $card_series->card_series_price = $request->card_series_price;
                        $card_series->card_series_universe_id = $request->universe_id;
                        $card_series->card_series_description = $request->card_series_description;
                        $card_series->card_series_is_active = $request->card_series_is_active;
                        if(isset($request->card_series_subtitle)){
                            $card_series->card_series_subtitle = $request->card_series_subtitle;
                        }
                        if(isset($request->card_series_book_id)){
                            $card_series->card_series_book_id = $request->card_series_book_id;
                        }
                    
                    $card_series->save();

            }

            //if request->step == 4
            if($request->step == 3){
              
                $universe_id =$card_series->universe->id;
                $card_series_id = $card_series->id ?? $request->card_series_id;
                return view('card-series.finish', compact('step', 'universe_id', 'card_series'));
               

            } else {
                
        
                $step = $request->type == 'edit' ? $request->step : $request->step += 1;
                $universe_id =$card_series->universe->id;
               $universe = Universe::find($universe_id);
                $card_series_id = $card_series->id ?? $request->card_series_id;
               
          
                
                if(isset($request->type) && $request->type == 'edit'){
                   
                    return view('universe.card-series.edit', compact('step','universe', 'universe_id', 'card_series_id', 'card_series'));
                } else {
                   
                    return view('universe.card-series.create', compact('step','universe', 'universe_id', 'card_series_id', 'card_series'));
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
        
        $card_series = CardSeries::find($request->c_id);
        // dd($card_series->toArray());
        $cards = $card_series->cards;
    
        // dd($issues->toArray());
       
        return view('universe/card-series/show', compact('card_series', 'cards'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // dd($request->all());
        //
        $card_series = CardSeries::find($request->card_series_id ?? $request->c_id);
       
        $step=isset($request->step) ? $request->step : 1;
        $universe = $card_series->universe;
        $type='edit';
        $eras = CardEra::all();
        $formattedDate = Carbon::parse($card_series->card_series_published_at)->format('Y-m-d');
        $books = Book::where('book_universe_id', $universe->id)->get();

        return view('universe/card-series/edit', compact('card_series', 'step','eras','books', 'universe', 'formattedDate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        dd($request->all());
        $request->validate([
            'card_series_id' => ['required'],
            'universe_id' => ['required'],
                 
        ]);

        ////make sure file is present
            if(!empty($request->file)){

                $fileName = $request->file('file')->getClientOriginalName();
                $path = 'universe/'.$request->universe_id.'/'.'card-series/'.$request->card_series_id.'/images';
        
                $file = $request->file('file');
            
                $s3 = Storage::disk('s3-public');
                $s3->putFileAs($path.$request->issue_number, $file, $fileName);
            }

            $cardSeriesService = new CardSeriesService($request->universe_id);

            $page_submitted = $cardSeriesService->checkCardSeries($path, $fileName);

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
            'card_series_id' => ['required']
        ]);
        $card_series = CardSeries::find($request->card_series_id);
        if($request->action == 'publish'){
            $card_series->card_series_is_active = 1;
            $card_series->save();
        } else {
            $card_series->card_series_is_active = 0;
            $card_series->save();
        }
       
        return redirect()->route('card-series.index', $card_series->card_series_universe_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //  dd($request->all());
         $request->validate([
            'card_series_id' => ['required'],
                 
        ]);
        $card_series = CardSeries::find($request->card_series_id);
        if($card_series->card_series_image_front) {
            if (Storage::disk('s3-public')->exists($card_series->card_series_image_front)) {
                Storage::disk('s3-public')->delete($card_series->card_series_image_front);
            }
        }
        if($card_series->card_series_image_back) {
            if (Storage::disk('s3-public')->exists($card_series->card_series_image_back)) {
                Storage::disk('s3-public')->delete($card_series->card_series_image_back);
            }
        }
        $card_series->delete();
         return response()->json(['success' => 'Card Series deleted successfully.']);
    }

        /**
     * Display a listing of the resource.
     */
    public function finish(REQUEST $request)
    {
        //
        // dd($request->all());
        $card_series = CardSeries::where('card_series_universe_id', $request->universe_id)->get();
        // dd($card_series->toArray());
       
    
        $universe = Universe::find($request->universe_id);

        $step = 3;


        return view('universe.card-series.index', compact('step', 'universe', 'card_series'));
       
    }

}

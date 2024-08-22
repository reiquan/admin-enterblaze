<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BookController;
use App\Models\Universe;
use App\Models\Book;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class UniverseController extends Controller
{
    use SoftDeletes;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $universes = Universe::where('universe_user_id', auth()->user()->id)
                                ->whereNull('deleted_at')->get();
        // dd($universes->toArray());
      
        return view('universe/index', compact('universes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    
        $universe = Universe::create();
        $universe_id = isset($request->universe_id) ? $request->universe_id : $universe->id;
        $step = 1;
       
        
        return view('universe/create', compact('step', 'universe', 'universe_id'));
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
         //validate info
         $request->validate([
            'universe_name' => ['required', 'string', 'max:255'],  
            'universe_description' => ['required', 'string', 'max:255'],   
            'universe_audience' => 'required',            
        ]);
        //save info
                //save universe
                    $universe = isset($request->universe_id) ? Universe::find($request->universe_id) : new Universe;
                        $universe->universe_name = $request->universe_name;
                        $universe->universe_description = $request->universe_description;
                        $universe->universe_audience = $request->universe_audience;
                        $universe->universe_is_active = 0;
                        $universe->universe_user_id = auth()->user()->id;
                        $universe->universe_slug_name = strtolower(str_replace(" ","_", $request->universe_name));
                    $universe->save();

           
            //if request->step == 4
            if($request->step == 4){
        
                return view('universe.index');
               

            } else {
                
     
                $step = $request->step += 1;
                // dd($universe->toArray());
                // if($universe->universe_image_url){
                    
                //     $image = $universe->universe_image_url;
                //     return view('universe.create', compact('universe', 'step', 'image'));
                // } else {
                if(isset($request->type) && $request->type == 'edit'){
                    return redirect()->route('universe.edit', ['universe_id' => $universe->id, 'step' => $step]);
                } else {
                    return redirect()->route('universe.create', ['universe_id' => $universe->id, 'step' => $step]);
                }
                   
                // }
               

            }
          ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $universe = Universe::find($id);
 
        return view('universe/show', compact('universe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        //
        $step=isset($request->step) ? $request->step : 1;
        $universe = Universe::find($id);
        $universe_id = $universe->id;
    //    if(!empty($request->all())){
    //     dd($request->all());
    //    }
        return view('universe/edit', compact('universe', 'step','universe_id'));
    }

     /**
     * Show the form for publishing the specified resource.
     */
    public function publish(Request $request, string $id)
    {
        //
        $universe = Universe::find($id);
        if($request->action == 'publish'){
            $universe->universe_is_active = 1;
            $universe->save();
        } else {
            $universe->universe_is_active = 0;
            $universe->save();
        }
       
        return redirect()->route('universe.index');
    }

  /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //validate info
        $request->validate([
            'universe_name' => ['required', 'string', 'max:255'],            
        ]);
        //save info
            //save universe
                $universe = isset($request->universe_id) ? Universe::find($request->universe_id) : new Universe;
                    $universe->universe_name = $request->universe_name;
                $universe->save();

           
 
            return view('admin/uploader', compact('step'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $request->validate([
            'universe_id' => ['required']
            // 'book_genres' => ['required'],
            
        ]);
        $universe = Universe::find($request->universe_id);
        $universe->deleted_at = now();
        $universe->save();
        $universes = Universe::where('universe_user_id', auth()->user()->id)
        ->whereNull('deleted_at')->get();
        return view('universe/index', compact('universes'));
    }
}

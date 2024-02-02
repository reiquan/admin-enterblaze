<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BookController;
use App\Models\Universe;
use App\Models\Book;
use Illuminate\Http\Request;
use Validator;

class UniverseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('universe/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
      
        $step = 1;
       
        
        return view('universe/create', compact('step'));
 
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
                    $universe = new Universe;
                        $universe->universe_name = $request->universe_name;
                        $universe->universe_description = $request->universe_description;
                        $universe->universe_audience = $request->universe_audience;
                    $universe->save();

           
            //if request->step == 4
            if($request->step == 4){
        
                return view('universe.index');
               

            } else {
                
     
                $step = $request->step += 1;
            
                return redirect()->route('universe.create', ['universe_id' => $universe->id, 'step' => $step]);

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
    public function edit(string $id)
    {
        //
        $universe = Universe::find($id);
        return view('universe/create', compact('universe'));
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
                $universe = new Universe;
                    $universe->universe_name = $request->universe_name;
                $universe->save();

           
 
            return view('admin/uploader', compact('step'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $universe = Universe::find($id)->destroy();
        return view('universe/index');
    }
}

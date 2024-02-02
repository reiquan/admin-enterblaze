<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BookController;
use App\Models\Universe;
use App\Models\Book;
use Illuminate\Http\Request;
use Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       
        $step = 1;

      
        return view('admin/uploader', compact('step'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($universe_id)
    {
        //
      
        $step = 1;
        $universe = Universe::find($universe_id);
        
        return view('universe/books/create', compact('step', 'universe'));
 
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
        $book = Book::find($id);
        return view('books/show', compact('books'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $universe = Book::find($id);
        return view('books/create', compact('books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //validate info
        $request->validate([
            'book_title' => ['required'],
            'book_creator' => ['required'],
            'book_audience' => ['required'],
            'book_description' => ['required'],
            'book_type' => ['required'],
            // 'book_genres' => ['required'],
            
        ]);
        //save info
            if(isset($request->step) and $request->step == 1){
                 //step 1
                //save universe
                    $universe = new Universe;
                        $universe->universe_name = $request->universe_name;
                    $universe->save();
                //save book
                    $book = new Book;
                        $book->book_title = $request->book_title;
                        $book->book_creator = $request->book_creator;
                        $book->book_audience = $request->book_audience;
                        $book->book_description = $request->book_description;
                        $book->book_type = $request->book_type;
                        if(isset($request->book_subtitle)){
                            $book->book_subtitle = $request->book_subtitle;
                        }
                        // $book->book_genres = $request->book_genres;
                        // if(isset($request->issue_number)){
                        //     $issue
                        //     $book->issue_number = $request->issue_number;
                        // }
                        // if(isset($request->volume_number)){
                        //     $book->volume_number = $request->volume_number;
                        // }
                    $book->save();

            }
           
            //step 2
                //save universe
                    //image_url
            //step3
                //if issue
                    //save issue
                        // issue_number
                //if volume
                    //save volume
                    // volume_number

        //if request->step == 4
            if($request->step == 4){
               
                return view('dashboard');
                dd('there');

            } else {
               
                $step = $request->step += 1;
 
                return view('admin/uploader', compact('step'));

            }
  

     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

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
    public function create(REQUEST $request)
    {
        dd($request->all());
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //validate info
        $request->validate([
            'universe_name' => ['required', 'string', 'max:255'],
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

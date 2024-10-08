<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BookController;
use App\Models\Universe;
use App\Models\Issue;
use App\Services\BookService;
use App\Models\IssuePage;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(REQUEST $request)
    {
        //

        $books = Book::where('book_universe_id', $request->universe_id)->get();
       
        $universe = Universe::find($request->universe_id);

        return view('universe/books/index', compact('books', 'universe'));
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
        $book_id = isset($_REQUEST['book_id']) ? $_REQUEST['book_id'] : '';
        $book = isset($_REQUEST['book']) ? $_REQUEST['book'] : '';
        return view('universe/books/create', compact('step', 'universe', 'universe_id', 'book_id', 'book'));
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->toArray());
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
               
                //save book
                    $book = isset($request->book_id) ? Book::find($request->book_id) : new Book;
                        $book->book_title = $request->book_title;
                        $book->book_creator = $request->book_creator;
                        $book->book_audience = $request->book_audience;
                        $book->book_description = $request->book_description;
                        $book->book_published_at = $request->book_published_at;
                        $book->book_universe_id = $request->universe_id;
                        $book->book_type = $request->book_type;
                        $book->book_price = $request->book_price;
                        if(isset($request->book_subtitle)){
                            $book->book_subtitle = $request->book_subtitle;
                        }
                        $new_slug_name = preg_replace('/[^a-zA-Z0-9\s]/', '', $request->book_title);
                        $book->book_slug_name = $new_slug_name;
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

           
            //if request->step == 4
            if($request->step == 3){
        
                return view('books.index');
               

            } else {
                
     
                $step = $request->step += 1;
                $universe_id = $request->universe_id;
                $book_id = $book->id;
                

                
                if(isset($request->type) && $request->type == 'edit'){
                    return view('universe.books.edit', compact('step', 'universe_id', 'book'));
                } else {
                    return view('universe.books.create', compact('step', 'universe_id', 'book_id', 'book'));
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
        $book = Book::find($request->b_id);
        $issues = $book->issues;
        // dd($issues->toArray());
       
        return view('universe/books/show', compact('book', 'issues'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $book = Book::find($request->book_id);
        $step=isset($request->step) ? $request->step : 1;;
        return view('universe/books/edit', compact('book', 'step'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       
        $request->validate([
            'book_id' => ['required'],
            'universe_id' => ['required'],
                 
        ]);

        ////make sure file is present
            if(!empty($request->file)){

                $fileName = $request->file('file')->getClientOriginalName();
                $path = 'universe/'.$request->universe_id.'/'.'books/'.$request->book_id.'/'.'pages/';
        
                $file = $request->file('file');
            
                $s3 = Storage::disk('s3-public');
                $s3->putFileAs($path.$request->issue_number, $file, $fileName);
            }

            $bookService = new BookService($request->universe_id);

            $page_submitted = $bookService->checkIssuePage($path, $fileName);

            if($page_submitted){
                return response()->json(['Success' => 'Page Uploaded Succesfully']);
            } else {
                return response()->json(['Error' => 'Page was not uploaded']);
            }
     
    }

         /**
     * Show the form for publishing the specified resource.
     */
    public function publish(Request $request, string $id)
    {
        //
        $request->validate([
            'book_id' => ['required']
        ]);
        $book = Book::find($request->book_id);
        if($request->action == 'publish'){
            $book->is_active = 1;
            $book->save();
        } else {
            $book->is_active = 0;
            $book->save();
        }
       
        return redirect()->route('books.index', $book->book_universe_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //  dd($request->all());
         $request->validate([
            'book_id' => ['required'],
                 
        ]);
        $book = Book::find($request->book_id);
        $issues= $book->issues;
        if($issues){
            foreach($issues as $issue) {
                 // Delete file from S3
                if (Storage::disk('s3-public')->exists($issue->issue_image_cover)) {
                    Storage::disk('s3-public')->delete($issue->issue_image_cover);
                    if($issue->pages) {
                        foreach($issue->pages as $page){
                            if (Storage::disk('s3-public')->exists($page->issue_page_url)) {
                                Storage::disk('s3-public')->delete($page->issue_page_url);
                                $page->delete();
                            }
                        }
                    }

                }

                $issue->delete();
            } 

        }
        if($book->book_image_path) {
            if (Storage::disk('s3-public')->exists($book->book_image_path)) {
                Storage::disk('s3-public')->delete($book->book_image_path);
            }
        }
        $book->delete();
         return response()->json(['success' => 'Book deleted successfully.']);
    }
}

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

class IssuesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(REQUEST $request)
    {
        // //
       
        // $books = Book::where('book_universe_id', $request->universe_id)->get();
       
        // $universe = Universe::find($request->universe_id);
      
        // return view('universe/books/index', compact('books', 'universe'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(REQUEST $request)
    {
        //
      
        $step = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;
        $universe = Universe::find($request->universe_id);
        $universe_id = isset($request->universe_id) ? $request->universe_id : '';
        $book_id = isset($request->book_id) ? $request->book_id : '';

        return view('universe/books/issues/create', compact('step', 'universe', 'universe_id', 'book_id'));
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
          //validate info
          $request->validate([
            'issue_title' => ['required'],

       
            'issue_description' => ['required'],
       
            // 'book_genres' => ['required'],
            
        ]);
        //save info
            if(isset($request->step) and $request->step == 1){
                //save book
                    $issue = new Issue;
                        $issue->issue_title = $request->issue_title;
                        $issue->issue_description = $request->issue_description;
                        $issue->issue_number = $request->issue_number;
                        $issue->issue_is_adult = $request->issue_is_adult ? 1 : 0;
                        $issue->issue_is_locked = 1;
                        $issue->issue_book_id = $request->book_id;
                        $issue->issue_slug_name = strtolower(str_replace(" ","_", $request->issue_title));
          
                        // $issue->issue_genres = $request->issue_genres;
                        // if(isset($request->issue_number)){
                        //     $issue
                        //     $issue->issue_number = $request->issue_number;
                        // }
                        // if(isset($request->volume_number)){
                        //     $issue->volume_number = $request->volume_number;
                        // }
                    $issue->save();

            }

           
            //if request->step == 4
            if($request->step == 4){
        
                return view('books.index');
               

            } else {
                
     
                $step = $request->step += 1;
                $universe_id = $request->universe_id;
                $book_id = $request->book_id;
                $issue_id = $issue->id ?? '';
              
                return view('universe.books.issues.create', compact('step', 'universe_id', 'book_id', 'issue_id'));

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
        $issue = Issue::find($request->issue_id);

        // dd($issue->pages->toArray());
      
        return view('universe/books/issues/show', compact('book', 'issue'));
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
     
        $request->validate([
            'book_id' => ['required'],
            'universe_id' => ['required'],
            'issue_id' => ['required'],
                 
        ]);
        $path;
        $fileName;

        ////make sure file is present
            if(!empty($request->file)){

                $fileName = $request->file('file')->getClientOriginalName();
                $path = 'universe/'.$request->universe_id.'/'.'books/'.$request->book_id.'/issues'.'/'.$request->issue_id.'/'.'pages/';
        
                $file = $request->file('file');
            
                $s3 = Storage::disk('s3-public');
                $s3->putFileAs($path.$request->issue_number, $file, $fileName);
            }
           

            $bookService = new BookService($request->universe_id);
            $page_submitted = $bookService->checkIssuePage($path, $fileName);

            // /Save to DB
            $issue_page = new IssuePage;
            $issue = Issue::find($request->issue_id);

            if($issue){
                $issue_page->issue_id = $request->issue_id;
                $issue_page->issue_page_url = $path.$fileName;
                $issue_page->save();
            }

            if($page_submitted){
                return response()->json(['success' => 'Page Uploaded Succesfully', 'issue_page_id' => $issue_page->id]);
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
        $book = Issue::find($id);
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
     * Show the form for publishing the specified resource.
     */
    public function pageIsVisible(Request $request, string $id)
    {
        //
     
        $request->validate([
            'issue_page_id' => ['required']
                 
        ]);
        $issue_page = IssuePage::find($request->page_id);
       
            $issue_page->issue_page_is_locked =  $issue_page->issue_page_is_locked == 1 ? 0 : 1;
            $issue_page->save();
       
        return response()->json(['success' => 'Page Updated  Succesfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'book_id' => ['required'],
            'universe_id' => ['required'],
            'issue_id' => ['required'],
                 
        ]);
        $issue= Issue::find($request->issue_id);
        if($issue){
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

                $issue->delete();
               
                return response()->json(['success' => 'File deleted successfully.']);
            } else {
                return response()->json(['Errr' => 'File Not Found']);
            }
            //
        }
    }
}

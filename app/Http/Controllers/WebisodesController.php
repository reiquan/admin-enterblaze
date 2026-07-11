<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BookController;
use App\Models\Universe;
use App\Models\Issue;
use App\Services\BookService;
use App\Models\Webisode;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Validator;

class WebisodesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(REQUEST $request, Universe $universe_id)
    {
        // //
      
        $webisodes = Webisode::where('webisode_universe_id', $universe_id->id)->where('deleted_at', null)->get();
       
        $universe = Universe::find($universe_id->id);

        return view('universe/webisodes/index', compact('universe', 'webisodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(REQUEST $request, Universe $universe_id)
    {
        //
    
        $step = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;
        $universe = Universe::find($request->universe_id)->load('books', 'cardSeries');
        $universe_id = isset($request->universe_id) ? $request->universe_id : '';
        $webisode = Webisode::find($request->webisode_id);
 


        if(intval($step) > 1){
           
            $issue = Issue::find($request->issue_id);
        }
        // dd($step, $universe->toArray(), $universe_id, $book_id, $issue->toArray());
        return view('universe/webisodes/create', compact('step', 'universe', 'universe_id','webisode'));
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Universe $universe_id)
    {
          //validate info
        

        $webisode = $request->webisode_id ? Webisode::find($request->webisode_id) : new webisode;
        //save info
            if(isset($request->step) and $request->step == 1){
                $request->validate([
                    'webisode_title',
                    
                ]);
      
                //save webisode
                        $webisode->webisode_universe_id = $universe_id->id;
                        $webisode->webisode_title = $request->webisode_title;
                        $webisode->webisode_description = $request->webisode_description;
                        $webisode->webisode_genre = $request->webisode_genre;
                        $webisode->webisode_status = $request->webisode_status ? 1 : 0;
                        $webisode->webisode_logline = $webisode->webisode_logline ?? 1;
                        $webisode->webisode_rating = $request->webisode_rating;
                        $webisode->webisode_tags = $request->webisode_tags;
                        $webisode->webisode_release_date = $request->webisode_release_date;
                        $webisode->webisode_slug = strtolower(str_replace(" ","_",  $request->webisode_title));
                        $webisode->webisode_price = $request->webisode_price;
                    $webisode->save();

            }

            $universe = $universe_id;
            //if request->step == 4
            if($request->step == 3){
               
                $webisodes = Webisode::where('webisode_universe_id', $universe->id)->get();
                // dd($webisodes->toArray());
       
                return view('universe.webisodes.index', compact('universe','webisodes'));
               

            } else {
                
     
                $step = $request->step += 1;
            
                // dd($universe);
    
              
                return view('universe.webisodes.create', compact('step', 'universe', 'webisode'));

            }
          ;
    }

  /**
     * Display the specified resource.
     */
    public function show(Request $request, Universe $universe_id, Webisode $webisode_id)
    {
        //
     
        $webisode = Webisode::find($webisode_id)->first();
        // dd($webisode->toArray());
        $universe = $webisode->universe;
    


        // dd($issue->pages->toArray());
      
        return view('universe/webisodes/show', compact('webisode', 'universe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Universe $universe_id, Webisode $webisode_id)
    {
        //

        $step = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;
        $webisode = Webisode::find($webisode_id)->first();
        $universe = $webisode->universe;

        return view('universe/webisodes/create', compact('webisode', 'step','universe'));
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
                if (IssuePage::where('issue_page_url', $path.$fileName)->get()->toArray()) {
                    //do nothing
                } else {
                    $issue_page->issue_id = $request->issue_id;
                    $issue_page->issue_page_url = $path.$fileName;
                    $count = count($issue->pages) ?? 0;
                    $issue_page->issue_page_number = $count += 1;
                    $issue_page->save();

                }
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
    public function publish(Request $request)
    {
        //
        $issue = Issue::find($request->issue_id);
        if($request->action == 'publish'){
            $issue->issue_is_locked = 1;
            $issue->save();
        } else {
            $issue->issue_is_locked = 0;
            $issue->save();
        }
       $universe_id =  $issue->book->universe->id;

        return response()->json(['success' => 'Issue Updated Succesfully', 'issue_id' => $issue->id]);
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
    public function destroy(Request $request, Universe $universe_id, Webisode $webisode_id)
    {
        // dd($request->all());
        $webisode= Webisode::find($webisode_id)->first();
        if($webisode){
             // Delete file from S3
            if($webisode->webisode_cover_image){
                Storage::disk('s3-public')->delete($webisode->webisode_cover_image);
            }
               
                $webisode->deleted_at = now();
                $webisode->save();
               
                return redirect()->route('webisodes.index', ['universe_id' => $universe_id]);

            //
        }
    }
}

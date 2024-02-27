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

class IssuePagesController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     */
    public function editPage(Request $request)
    {
        //
        
        $issue_page = IssuePage::find($request->issue_page_id);
       
        return view('universe/books/issues/edit', compact('issue_page'));
    }

        /**
     * Show the form for editing the specified resource.
     */
    public function addPage(Request $request)
    {
        //

        
        $issue = Issue::find($request->issue_id);
       
        return view('universe/books/issues/add-page', compact('issue'));
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
            'issue_page_id' => ['required'],

                 
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
                $num = 0;
                $issue_page->issue_id = $request->issue_id;
                $issue_page->issue_page_url = $path.$fileName;
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
    
        $request->validate([
            'issue_page_id' => ['required']
                 
        ]);
        $issue_page = IssuePage::find($request->issue_page_id);
        // dd($issue_page->toArray());
        if($issue_page){
             // Delete file from S3
            if (Storage::disk('s3-public')->exists($issue_page->issue_page_url)) {
                Storage::disk('s3-public')->delete($issue_page->issue_page_url);
                $issue_page->delete();
                return response()->json(['success' => 'File deleted successfully.']);
            } else {
                return response()->json(['error' => 'File Not Found']);
            }
            //
        }
    }
}

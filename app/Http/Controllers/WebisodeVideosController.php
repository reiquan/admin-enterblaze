<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BookController;
use App\Models\Universe;
use App\Models\Issue;
use App\Services\BookService;
use App\Models\Webisode;
use App\Models\WebisodeVideo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Validator;

class WebisodeVideosController extends Controller
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
    public function create(REQUEST $request, Universe $universe_id, Webisode $webisode_id)
    {
        //
        // dd($webisode_id->id);
        $step = $request->step ?? 1;
        $webisode = Webisode::find($webisode_id->id)->first();
        $webisode_video = WebisodeVideo::find($request->webisode_video_id);
        $universe = Universe::find($universe_id->id)->first();
 

        // dd($step, $universe->toArray(), $universe_id, $book_id, $issue->toArray());
        return view('universe/webisodes/webisode-videos/create', compact('step','universe','webisode', 'webisode_video'));
 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Universe $universe_id, Webisode $webisode_id, WebisodeVideo $webisode_video_id = null)
    {
          //validate info
       

        $webisode = $request->webisode_id ? Webisode::find($request->webisode_id) : new webisode;
        //save info
       
            if(isset($request->step) and $request->step == 1){
                $validated = $request->validate([
                    'video_title' => ['required', 'string', 'max:255'],
                    'video_number' => ['required', 'integer', 'min:1'],
                    'video_sort_order' => ['nullable', 'integer'],
                    'video_rating' => ['nullable', 'string'],
                    'video_publish_at' => ['nullable', 'date'],
                    'video_description' => ['nullable', 'string'],
                    'video_price' => ['nullable', 'numeric'],
                    'video_tags' => ['nullable'],
                ]);
            
                $tags = [];
            
                if (!empty($request->video_tags)) {
                    $decoded = json_decode($request->video_tags, true);
            
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $tags = $decoded;
                    }
                }
                if(isset($request->webisode_video_id) && $request->webisode_video_id){
                    $webisode_video = WebisodeVideo::find($request->webisode_video_id)->first();
                    $webisode_video->update([
                    'webisode_id' => $webisode_id->id,
            
                    'video_title'=> $request->video_title,
                    'video_slug'=> Str::slug($request->video_title),
            
                    'video_number'=> $request->video_number,
                    'video_sort_order'=> $request->video_sort_order ?? 0,
            
                    'video_rating'=> $request->video_rating,
                    'video_publish_at'=> $request->video_publish_at,
            
                    'video_description'=> $request->video_description,
            
                    'video_price' => $request->video_price,
                    'video_blaze_token_cost'=> intval($request->video_blaze_token_cost )/ intval(config('auth.blaze_tokens.exchange')) ?? 0,
            
                    'video_is_free'=> $request->boolean('video_is_free'),
                    'video_is_locked'=> $request->boolean('video_is_locked'),
                    'video_is_featured'=> $request->boolean('video_is_featured'),
                    'video_is_published'=> $request->boolean('video_is_published'),
            
                    'video_tags'=> $tags,
            
                    'video_view_count'=> 0,
                    'video_like_count' => 0,
                    'video_comment_count'=> 0,
                ]);

                } else {
                    $webisode_video = WebisodeVideo::create([
                        'webisode_id' => $webisode_id->id,
                
                        'video_title'=> $request->video_title,
                        'video_slug'=> Str::slug($request->video_title),
                
                        'video_number'=> $request->video_number,
                        'video_sort_order'=> $request->video_sort_order ?? 0,
                
                        'video_rating'=> $request->video_rating,
                        'video_publish_at'=> $request->video_publish_at,
                
                        'video_description'=> $request->video_description,
                
                        'video_price' => $request->video_price,
                        'video_blaze_token_cost'=> $request->video_blaze_token_cost ?? 0,
                
                        'video_is_free'=> $request->boolean('video_is_free'),
                        'video_is_locked'=> $request->boolean('video_is_locked'),
                        'video_is_featured'=> $request->boolean('video_is_featured'),
                        'video_is_published'=> $request->boolean('video_is_published'),
                
                        'video_tags'=> $tags,
                
                        'video_view_count'=> 0,
                        'video_like_count' => 0,
                        'video_comment_count'=> 0,
                    ]);
                }
             
                $step = $request->step += 1;
                $universe = $universe_id;
                $webisode = $webisode_id;
                $webisode_video_id = $webisode_video->id;
                return redirect()->route('webisode-videos.create', compact('universe_id','webisode_id', 'webisode_video_id', 'step'));

            }


            


            $universe = $universe_id;
            //if request->step == 4
            if($request->step == 3){
               
                $webisodes = Webisode::where('webisode_universe_id', $universe_id->id)->where('deleted_at', null)->get();
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
    public function update(Request $request, Universe $universe_id, Webisode $webisode_id, WebisodeVideo $webisode_video_id)
    {
      if(!$webisode_video_id->video_path) {
            $validated = $request->validate([
                'video_file' => [
                    'required',
                    'file',
                    'mimetypes:video/mp4,video/quicktime,video/webm,video/x-m4v',
                ],
                'video_thumbnail' => [
                    'required',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:10000',
                ],
                'video_duration_seconds' => [
                    'required',
                    'integer',
                    'max:300',
                ],
            ], [
                'video_duration_seconds.max' => 'Videos cannot be longer than five minutes.',
            ]);
     
            $webisode_video = $request->webisode_video_id ? WebisodeVideo::find($webisode_video_id->id)->first() : null;

            $videoPath = $request->file('video_file')->store(
                '/universe/'. $universe_id->id .'/webisodes/'.$webisode_id->id.'/webisode-videos/'.$webisode_video->id,
                's3-public'
            );
        
            $thumbnailPath = $request->file('video_thumbnail')->store(
                '/universe/'. $universe_id->id .'/webisodes/'.$webisode_id->id.'/webisode-videos/'.$webisode_video->id.'/thumbnails',
                's3-public'
            );
        
            $webisode_video->update([
                'video_path' => $videoPath,
                'video_thumbnail' => $thumbnailPath,
                'video_duration_seconds' => $validated['video_duration_seconds'],
                'video_mime_type' => $request->file('video_file')->getMimeType(),
                'video_file_size' => $request->file('video_file')->getSize(),
            ]);
        }
        
        // dd($webisode_video->toArray());
        $step = $request->step += 1;
        $universe = $universe_id;
        $webisode = $webisode_id;
        $webisode_video = $webisode_video_id;
        $webisode_video_id = $webisode_video->id ?? $webisode_video_id->id;
        return view('universe.webisodes.webisode-videos.create', compact('universe','webisode', 'webisode_video', 'step', 'webisode_video_id'));
     
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
    public function destroy(Request $request, Universe $universe_id, Webisode $webisode_id, WebisodeVideo $webisode_video_id)
    {
        // dd($request->all());
        $webisode_video= WebisodeVideo::find($webisode_video_id->id)->first();
        if($webisode_video){
             // Delete file from S3
            if($webisode_video->video_path){
                Storage::disk('s3-public')->delete($webisode_video->video_path);
            }
            if($webisode_video->video_thumbnail){
                Storage::disk('s3-public')->delete($webisode_video->video_thumbnail);
            }  
                $webisode_video->deleted_at = now();
                $webisode_video->save();
               
                return redirect()->route('webisodes.index', ['universe_id' => $universe_id]);

            //
        }
    }
}

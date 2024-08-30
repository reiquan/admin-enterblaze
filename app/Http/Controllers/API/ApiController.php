<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Universe;
use App\Models\Issue;
use App\Services\BookService;
use App\Models\IssuePage;
use App\Models\Book;

class ApiController extends Controller
{
 
    
    public function getUniverses()
    {
        return response()
                ->json(Universe::where('universe_is_active', 1)
                ->get()
                ->makeHidden(
                    [
                        'deleted_at',
                        'created_at',
                        'universe_is_active',
                        'universe_user_id'
                    ]
                )->toArray(), 200);
    }

    public function getBooks()
    {
        return response()
                ->json(Book::all()
                ->load('issues')
                ->makeHidden(
                    [
                        'created_at',
                    ]
                )->toArray(), 200);
    }

    public function getChapters(Request $request)
    {
        $pages = IssuePage::where('issue_id', $request->issue_id)->with('issue')->get();
        $issue = Issue::where('issue_book_id', $pages[0]['issue']['issue_book_id'])
                        ->orderBy('issue_number')
                        ->get();    
        $pages->put('chapters', $issue); 

        return response()
                ->json($pages, 
                200
               );
    }

}

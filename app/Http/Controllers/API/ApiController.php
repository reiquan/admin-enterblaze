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
        return response()->json(Universe::all(), 200);
    }

}

<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\CardSeries;
use Illuminate\Support\Facades\Storage;


class CardSeriesService
{
    
    public function __construct($universe_id){

        $this->universe_id = $universe_id;

    }

      /**
     * check if page exists
     */
    public function checkCardSeries($path, $page_url)
    {
      // Specify the path of the file in your S3 bucket
        $filePathInS3 = $path.$page_url;

        // Retrieve the file contents
        $fileContents = Storage::disk('s3-public')->get($filePathInS3);

        if(!empty($fileContents)){

            return true;

        } else {

            return false;

        }
    }

    
}
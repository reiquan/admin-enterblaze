<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServicesController extends Controller
{
    //

    public function index(Request $request){
    
        $services  = Service::whereNULL('deleted_at')->get();
 

        return view('services.index', compact('services'));
    }

    public function show(Request $request){
    

        return view('tokens.show');
    }
    public function create(Request $request){

        return view('services.create');
    }

    public function edit(Request $request){
    
        $service  = Service::find($request->service_id);


        return view('services.edit', compact('service'));
    }

    public function submit(Request $request){
        // dd($request->all());

        $service = Service::create([
            'service_name' => $request->service_name,
            'service_description' => $request->service_description,
            'service_tag' => $request->service_tag,
            'service_perks' => $request->service_perks,
            'service_featured' => $request->service_featured,
            'service_category' => $request->service_category,
            'service_category' => $request->service_category,
            'service_is_on_sale' => $request->service_is_on_sale,
            'service_frequency' => $request->service_frequency,
            'service_sale_percentage' => $request->service_sale_percentage,
            'service_sale_ends_at' => $request->service_sale_ends_at,
            'service_price' => $request->service_price,
            'service_is_active' => 0,
        ]);

        return redirect()->route('services.index');
    }

    public function update(Request $request){
       

        $service = Service::find($request->service_id);

            $service->service_name = $request->service_name;
            $service->service_description = $request->service_description;
            $service->service_price = $request->service_price;
            $service->service_featured = $request->service_featured;
            $service->service_category = $request->service_category;
            $service->service_is_on_sale = $request->service_is_on_sale;
            $service->service_sale_percentage = $request->service_sale_percentage;
            $service->service_sale_ends_at = $request->service_sale_ends_at;
            $service->service_frequency = $request->service_frequency;
            $service->service_is_active = 0;

        $service->save();
        
        return redirect()->route('services.index');
    }

           /**
     * Show the form for publishing the specified resource.
     */
    public function publish(Request $request, string $id)
    {
        //
        $service = Service::find($id);
        if($request->action == 'publish'){
            $service->service_is_active = 1;
            $service->save();
        } else {
            $service->service_is_active = 0;
            $service->save();
        }
       
        return redirect()->route('services.index');
    }
    
    public function destroy(Request $request){
        $service = Service::find($request->service_id);
        $service->deleted_at = now();
        $service->save();
        return redirect()->route('services.index');
    }
}

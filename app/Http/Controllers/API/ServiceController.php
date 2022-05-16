<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Service;
use App\Http\Resources\ServiceResource;

//  ['name', 'services','platform', 'desc']
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Service::latest()->get();
        return response()->json([ServiceResource::collection($data), 'Data Service Telah Terpanggil.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'services' => 'required',
            'platform' => 'required',
            'desc' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $service = Service::create([
            'name' => $request->name,
            'services' => $request->services,
            'platform' => $request->platform,
            'desc' => $request->desc
         ]);
        
        return response()->json(['Services Berhasil Dibuat.', new ServiceResource($service)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);
        if (is_null($service)) {
            return response()->json('Data Tidak Ditemukan', 404); 
        }
        return response()->json([new ServiceResource($service)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'services' => 'required|string',
            'platform' => 'required',
            'desc' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        // Return Fail Response
        $service->name = $request->name;
        $service->services = $request->services;
        $service->platform = $request->platform;
        $service->desc = $request->desc;
        $service->save();
        
        return response()->json(['Service Berhasil Diubah.', new ServiceResource($service)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json('Service Berhasil Dihapus');
    }
}
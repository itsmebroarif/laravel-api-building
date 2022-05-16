<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Gallery;
use App\Http\Resources\GalleryResource;

// [name, picture,headline,subheadline, desc]
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Gallery::latest()->get();
        return response()->json([GalleryResource::collection($data), 'Data Gallery Telah Terpanggil.']);
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
            'picture' => 'required',
            'headline' => 'required',
            'subheadline' => 'required',
            'desc' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $gallery = Gallery::create([
            'name' => $request->name,
            'picture' => $request->picture,
            'headline' => $request->headline,
            'subheadline' => $request->subheadline,
            'desc' => $request->desc
         ]);
        
        return response()->json(['Galleries Berhasil Dibuat.', new GalleryResource($gallery)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = Gallery::find($id);
        if (is_null($gallery)) {
            return response()->json('Data Tidak Ditemukan', 404); 
        }
        return response()->json([new GalleryResource($gallery)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'picture' => 'required',
            'headline' => 'required',
            'subheadline' => 'required',
            'desc' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $gallery->name = $request->name;
        $gallery->picture = $request->picture;
        $gallery->headline = $request->headline;
        $gallery->subheadline = $request->subheadline;
        $gallery->desc = $request->desc;
        $gallery->save();
        
        return response()->json(['Gallery Berhasil Diubah.', new GalleryResource($gallery)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return response()->json('Gallery Berhasil Dihapus');
    }
}
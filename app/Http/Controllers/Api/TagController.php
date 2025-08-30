<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tag::orderBy('id','desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // validate
        $this->validate($request,[
            'tagName' => 'required'
        ]);
        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // validate
        $this->validate($request,[
            'id' => 'required',
            'tagName' => 'required'
        ]);
        return Tag::where('id',$request->id)->update([
            'tagName' => $request->tagName
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // validate
        $this->validate($request,[
            'id' => 'required',
        ]);
        return Tag::where('id',$request->id)->delete();
    }
}

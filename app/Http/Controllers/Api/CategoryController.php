<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::orderBy('id','desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // validate
        $this->validate($request,[
            'categoryName' => 'required'
        ]);
        return Category::create([
            'categoryName' => $request->categoryName
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
            'categoryName' => 'required'
        ]);
        return Category::where('id',$request->id)->update([
            'categoryName' => $request->categoryName
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
        return Category::where('id',$request->id)->delete();
    }
}

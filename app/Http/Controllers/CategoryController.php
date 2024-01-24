<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return response()->json($categories);
        //return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            //'error' => false,
         'message' => 'no tienes acceso'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'name' => 'required|string|min:1|max:100'
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => False,
                'message' => $validator->errors()->all()
            ]);
        } else {
            $category = new Category($request->input());
            $category->save();
            return response()->json([
              'status' => True,
              'message' => 'Category created successfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$category = DB::table("categories")->where('id','=', $id)->get();
        //$category = DB::select("select * from categories where id = '$id'");
        $category = Category::find($id);
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $rules = [
            'name' =>'required|string|min:1|max:100'
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
               'status' => False,
               'message' => $validator->errors()->all()
            ]);
        } else {
            $category = Category::find($id);
            $category->name = $request->name;
            $category->save();
            return response()->json([
              'status' => True,
              'message' => 'Category updated successfully'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $newStatus = ($category->status == 1) ? 0 : 1;
        $category->status = $newStatus;
        $category->save();
        return response()->json([
          'status' => True,
          'message' => 'Category deleted successfully'
        ]);
    }
}

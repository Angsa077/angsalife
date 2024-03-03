<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Lib\Helper;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use Helper;
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->input('all')) {
            $categories = Category::orderBy('id', 'DESC')->get();
        } else {
            $categories = Category::paginate(10);
        }
        return response()->json(['data' => $categories], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth("api")->user()->is_admin) {
            return response()->json(['message' => 'Unauthorize'], 500);
        }
        $this->validate($request, [
            'title' => 'required'
        ]);
        $category = new Category();
        $category->title = $request->input('title');
        $category->slug = $this->slugify($category->title);
        $category->save();
        return response()->json(['data' => $category, 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return response()->json(['data' => $category], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth("api")->user()->is_admin) {
            return response()->json(['message' => 'Unauthorize'], 500);
        }
        $category = Category::findOrFail($id);
        $this->validate($request, [
            'title' => 'required'
        ]);
        $category->title = $request->input('title');
        $category->slug = $this->slugify($category->title);
        $category->save();
        return response()->json(['data' => $category, 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth("api")->user()->is_admin) {
            return response()->json(['message' => 'Unauthorize'], 500);
        }
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}

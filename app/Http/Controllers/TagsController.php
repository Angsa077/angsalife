<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
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
            $tags = Tag::all();
        } else {
            $tags = Tag::paginate(10);
        }
        return response()->json(['data' => $tags], 200);
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
        $tag = new Tag();
        $tag->title = $request->input('title');
        $tag->save();
        return response()->json(['data' => $tag, 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tag = Tag::findOrFail($id);
        return response()->json(['data' => $tag], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth("api")->user()->is_admin) {
            return response()->json(['message' => 'Unauthorize'], 500);
        }
        $tag = Tag::findOrFail($id);
        $this->validate($request, [
            'title' => 'required'
        ]);
        $tag->title = $request->input('title');
        $tag->save();
        return response()->json(['data' => $tag, 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth("api")->user()->is_admin) {
            return response()->json(['message' => 'Unauthorize'], 500);
        }
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}

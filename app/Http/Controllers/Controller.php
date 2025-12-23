<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Request;

abstract class Controller
{
   public function index()
{
    return Post::all();
}

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
    ]);
    return Post::create($validated);
}

public function show(Post $post)
{
    return $post;
}

public function update(Request $request, Post $post)
{
    $validated = $request->validate([
        'title' => 'sometimes|required|string|max:255',
        'body' => 'sometimes|required|string',
    ]);
    $post->update($validated);
    return $post;
}

public function destroy(Post $post)
{
    $post->delete();
    return response()->json(null, 204);
}
}

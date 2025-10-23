<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //
    public function index()
    {
        $news = News::with('categories:id,name,slug')
            ->published()
            ->latest('published_at')
            ->take(12)
            ->get(['id','title','image_url','excerpt','published_at']);

        return response()->json($news);
    }


    public function create()
    {
        $categories = Category::orderBy('name')->get(['id','name']);
        return view('news.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'excerpt'     => 'nullable|string|max:500',
            'body'     => 'required|string',
            'image_url'   => 'nullable|url',
            'published_at'=> 'nullable|date',
            'categories'  => 'required|array',
            'categories.*'=> 'exists:categories,id',
        ]);

        // asigna usuario loggeado
        $validated['user_id'] = auth()->id();

        if (empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $news = News::create($validated);

        $news->categories()->sync($request->categories);

        return redirect()->route('dashboard')->with(
            'status',
            'Noticia creada correctamente.'
        );
    }
}

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
        $perPage = (int) request('per_page', 3);

        $news = News::with('categories:id,name,slug')
            ->published()
            ->latest('published_at')
            ->paginate($perPage, ['id','title','image_url','excerpt','published_at']);

        return response()->json([
            'data' => $news->items(),
            'meta' => [
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage(),
                'per_page' => $news->perPage(),
                'total' => $news->total(),
            ],
            'links' => [
                'next' => $news->nextPageUrl(),
                'prev' => $news->previousPageUrl(),
            ],
        ]);
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

    public function byCategory($id)
    {
        $perPage = (int) request('per_page', 3);

        $news = News::whereHas('categories', function ($q) use ($id) {
            $q->where('categories.id', $id);
        })
            ->published()
            ->latest('published_at')
            ->paginate($perPage, ['id', 'title', 'image_url', 'excerpt', 'published_at']);

        return response()->json([
            'data' => $news->items(),
            'meta' => [
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage(),
                'per_page' => $news->perPage(),
                'total' => $news->total(),
            ],
            'links' => [
                'next' => $news->nextPageUrl(),
                'prev' => $news->previousPageUrl(),
            ],
        ]);
    }

    public function show($id)
    {
        $item = News::with('categories:id,name,slug')
            ->published()
            ->findOrFail($id, ['id', 'title', 'image_url', 'body', 'published_at']);
        return response()->json($item);
    }

    public function recommended($id)
    {
        $current = News::findOrFail($id);

        $recommended = News::published()
            ->where('id', '<>', $current->id)
            ->latest('published_at')
            ->take(3)
            ->get(['id', 'title', 'image_url', 'excerpt', 'published_at']);

        return response()->json($recommended);
    }
}

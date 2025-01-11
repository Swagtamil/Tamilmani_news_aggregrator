<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{

      /**
     * @OA\Get(
     *     path="/api/articles",
     *     summary="Fetch all articles",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="List of articles"),
     *     @OA\Response(response="500", description="Internal server error")
     * )
     */
    public function index(Request $request)
    {
        $cacheKey = 'articles_' . md5($request->fullUrl());
        $articles = Cache::remember($cacheKey, 60, function () use ($request) {
            return Article::query()
                ->when($request->keyword, fn($q) => $q->where('title', 'like', "%{$request->keyword}%"))
                ->when($request->category, fn($q) => $q->where('category', $request->category))
                ->when($request->source, fn($q) => $q->where('source', $request->source))
                ->paginate(10);
        });
    
        return response()->json($articles);
    }

    /**
     * @OA\Get(
     *     path="/api/articles/{id}",
     *     summary="Fetch a single article by ID",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the article",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Article details"),
     *     @OA\Response(response="404", description="Article not found")
     * )
     */
    
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    public function dashboard(Request $request)
    {
        $articles = Article::paginate(10);  
        return view('articles.index', compact('articles'));
    }
}

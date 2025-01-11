<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    /**
     * Show the authenticated user's preferences.
     * @OA\Get(
     *     path="/api/preferences",
     *     summary="Get user preferences",
     *     tags={"Preferences"},
     *     @OA\Response(
     *         response="200",
     *         description="User preferences retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="categories", type="array", @OA\Items(type="string", example="Technology")),
     *             @OA\Property(property="sources", type="array", @OA\Items(type="string", example="BBC"))
     *         )
     *     )
     * )
     */
    public function show(Request $request)
    {
        return response()->json($request->user()->preferences);
    }

    /**
     * Store or update the user's preferences.
     * @OA\Post(
     *     path="/api/preferences",
     *     summary="Store or update user preferences",
     *     tags={"Preferences"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="categories", type="array", @OA\Items(type="string", example="Technology")),
     *             @OA\Property(property="sources", type="array", @OA\Items(type="string", example="BBC"))
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Preferences updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="categories", type="array", @OA\Items(type="string", example="Technology")),
     *             @OA\Property(property="sources", type="array", @OA\Items(type="string", example="BBC"))
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", 
     *                 @OA\Property(property="categories", type="array", @OA\Items(type="string", example="The categories field is required."))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $preferences = $request->user()->preferences()->updateOrCreate([], $request->all());
        return response()->json($preferences);
    }

    /**
     * Fetch personalized articles based on user preferences.
     * @OA\Get(
     *     path="/api/personalized-feed",
     *     summary="Get personalized news feed based on user preferences",
     *     tags={"Preferences"},
     *     @OA\Response(
     *         response="200",
     *         description="Personalized articles retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", 
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Breaking News in Tech"),
     *                     @OA\Property(property="category", type="string", example="Technology"),
     *                     @OA\Property(property="source", type="string", example="BBC"),
     *                     @OA\Property(property="content", type="string", example="Some news content here")
     *                 )
     *             ),
     *             @OA\Property(property="meta", type="object", 
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=5),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="total", type="integer", example=50)
     *             )
     *         )
     *     )
     * )
     */
    public function fetchPersonalizedFeed(Request $request)
    {
        $preferences = $request->user()->preferences;

        $articles = Article::query()
            ->when($preferences->categories, fn($q) => $q->whereIn('category', $preferences->categories))
            ->when($preferences->sources, fn($q) => $q->whereIn('source', $preferences->sources))
            ->paginate(10);

        return response()->json($articles);
    }
}

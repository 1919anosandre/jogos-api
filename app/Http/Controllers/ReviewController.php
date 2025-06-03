<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Se quiser, pode carregar o game junto
        return Review::with('game')->get();
    }

    public function store(ReviewRequest $request)
    {
        $review = Review::create($request->validated());
        return response()->json($review, 201);
    }

    public function show(Review $review)
    {
        return $review->load('game');
    }

    public function update(ReviewRequest $request, Review $review)
    {
        $review->update($request->validated());
        return response()->json($review);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json(null, 204);
    }
}

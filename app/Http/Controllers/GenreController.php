<?php
namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Requests\GenreRequest;

class GenreController extends Controller
{
    public function index()
    {
        return Genre::all();
    }

    public function store(GenreRequest $request)
    {
        $genre = Genre::create($request->validated());
        return response()->json($genre, 201);
    }

    public function show(Genre $genre)
    {
        return $genre;
    }

    public function update(GenreRequest $request, Genre $genre)
    {
        $genre->update($request->validated());
        return response()->json($genre);
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->json(null, 204);
    }

    public function create()
    {
        return view('genres.create'); // Crie esse arquivo em resources/views/genres/create.blade.php
    }

public function indexView()
{
    $genres = Genre::all();
    return view('genres.index', compact('genres'));  // Passa para a view
}

}

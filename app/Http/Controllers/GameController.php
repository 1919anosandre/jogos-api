<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Http\Requests\GameRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'indexView', 'show']);
    }

    // API: Retorna JSON com todos os games
    public function index()
    {
        return Game::with(['genre', 'platforms', 'reviews'])->get();
    }

    // WEB: Exibe a view com lista de games
    public function indexView()
    {
        $games = Game::with(['genre', 'platforms', 'reviews'])
                    ->orderBy('title')
                    ->paginate(10);

        return view('games.index', compact('games'));
    }

    // WEB: Exibe formulário de criação
    public function create()
    {
        $genres = Genre::all();
        $platforms = Platform::all();

        return view('games.create', compact('genres', 'platforms'));
    }

    // API: Armazena novo game
    public function store(GameRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $game = Game::create($request->validated());

            if ($request->has('platforms')) {
                $game->platforms()->sync($request->platforms);
            }

            DB::commit();
            
            return response()->json($game->load(['genre', 'platforms', 'reviews']), 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating game: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to create game',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // API/WEB: Exibe um game específico
    public function show(Game $game)
    {
        return $game->load(['genre', 'platforms', 'reviews']);
    }

    // WEB: Exibe formulário de edição
    public function edit(Game $game)
    {
        $this->authorize('update', $game);
        
        $game->load(['genre', 'platforms']);
        $genres = Genre::all();
        $platforms = Platform::all();

        return view('games.edit', compact('game', 'genres', 'platforms'));
    }

    // API: Atualiza um game
    public function update(GameRequest $request, Game $game)
    {
        $this->authorize('update', $game);

        DB::beginTransaction();
        
        try {
            $game->update($request->validated());
            
            $platforms = $request->input('platforms', []);
            $game->platforms()->sync($platforms);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $game->load(['genre', 'platforms', 'reviews'])
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating game: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating game',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // API: Remove um game
    public function destroy(Game $game)
    {
        $this->authorize('delete', $game);

        DB::beginTransaction();
        
        try {
            $game->platforms()->detach();
            $game->reviews()->delete();
            $game->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Game deleted successfully'
            ], 204);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting game: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting game',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
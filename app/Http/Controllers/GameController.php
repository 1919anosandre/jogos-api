<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Http\Requests\GameRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct()
    {
        // Protege apenas ações que modificam dados sensíveis
        $this->middleware('auth')->only(['edit', 'update', 'destroy']);
    }

    /**
     * API: Retorna JSON com todos os games
     */
    public function index()
    {
        try {
            $games = Game::with(['genre', 'platforms', 'reviews'])->get();
            return response()->json($games);
        } catch (\Exception $e) {
            Log::error('Error fetching games: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch games'], 500);
        }
    }

    /**
     * WEB: Exibe a view com lista de games paginados
     */
    public function indexView()
    {
        try {
            $games = Game::with(['genre', 'platforms', 'reviews'])
                        ->orderBy('title')
                        ->paginate(10);

            return view('games.index', compact('games'));
        } catch (\Exception $e) {
            Log::error('Error loading games view: ' . $e->getMessage());
            abort(500, 'Error loading games');
        }
    }

    /**
     * WEB: Exibe formulário de criação
     */
    public function create()
    {
        try {
            $genres = Genre::all();
            $platforms = Platform::all();
            return view('games.create', compact('genres', 'platforms'));
        } catch (\Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading form');
        }
    }

    /**
     * API: Armazena novo game (POST /games)
     */
    public function store(Request $request) // Alterado para Request normal
    {
        // Validação manual (substitui o GameRequest)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'genre_id' => 'required|exists:genres,id',
            'platforms' => 'sometimes|array',
            'platforms.*' => 'exists:platforms,id'
        ]);

        DB::beginTransaction();
        
        try {
            $game = Game::create($validated);

            if ($request->has('platforms')) {
                $game->platforms()->sync($request->platforms);
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $game->load(['genre', 'platforms'])
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating game: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create game',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API/WEB: Exibe um game específico
     */
    public function show(Game $game)
    {
        try {
            return response()->json($game->load(['genre', 'platforms', 'reviews']));
        } catch (\Exception $e) {
            Log::error('Error fetching game: ' . $e->getMessage());
            return response()->json(['error' => 'Game not found'], 404);
        }
    }

    /**
     * WEB: Exibe formulário de edição
     */
    public function edit(Game $game)
    {
        try {
           // $this->authorize('update', $game);
            
            $game->load(['genre', 'platforms']);
            $genres = Genre::all();
            $platforms = Platform::all();

            return view('games.edit', compact('game', 'genres', 'platforms'));
        } catch (\Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading form');
        }
    }

    /**
     * API: Atualiza um game
     */
    public function update(Request $request, Game $game) // Alterado para Request normal
    {
       // $this->authorize('update', $game);

        // Validação manual
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'genre_id' => 'sometimes|exists:genres,id',
            'platforms' => 'sometimes|array',
            'platforms.*' => 'exists:platforms,id'
        ]);

        DB::beginTransaction();
        
        try {
            $game->update($validated);
            
            if ($request->has('platforms')) {
                $game->platforms()->sync($request->platforms);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $game->load(['genre', 'platforms'])
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

    /**
     * API: Remove um game
     */
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
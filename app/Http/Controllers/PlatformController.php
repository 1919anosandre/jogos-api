<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use App\Http\Requests\PlatformRequest; // supondo que exista esse FormRequest

class PlatformController extends Controller
{
    public function index()
    {
        return Platform::all();
    }

    public function store(PlatformRequest $request)
    {
        $platform = Platform::create($request->validated());
        return response()->json($platform, 201);
    }

    public function show(Platform $platform)
    {
        return $platform;
    }

    public function update(PlatformRequest $request, Platform $platform)
    {
        $platform->update($request->validated());
        return response()->json($platform);
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();
        return response()->json(null, 204);
    }

    // Apenas um método indexView correto:
    public function indexView()
    {
        $platforms = Platform::all();
        return view('platforms.index', compact('platforms'));
    }

    public function edit(Platform $platform)
{
    return view('platforms.edit', compact('platform'));
}

}

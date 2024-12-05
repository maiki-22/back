<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
{
    // Ver todas las playlists
    public function getAll()
    {
        $playlists = Playlist::all();
        return response()->json($playlists);
    }

    // Ver una playlist
    public function show($id)
    {
        $playlist = Playlist::findOrFail($id);
        return response()->json($playlist);
    }

    // Crear una playlist
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $playlist = Playlist::create($request->all());
        return response()->json($playlist, 201);
    }

    // Modificar una playlist
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $playlist = Playlist::findOrFail($id);
        $playlist->update($request->all());
        return response()->json($playlist);
    }

    // Eliminar una playlist
    public function delete($id)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->delete();
        return response()->json(null, 204);
    }

    // Agregar canciones a una playlist
    public function addTrack(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'track_id' => 'required|exists:track,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $playlist = Playlist::findOrFail($id);
        $track = Track::findOrFail($request->track_id);
        $playlist->tracks()->attach($track);
        return response()->json($playlist->tracks);
    }

    // Eliminar canciones de una playlist
    public function removeTrack(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'track_id' => 'required|exists:track,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $playlist = Playlist::findOrFail($id);
        $track = Track::findOrFail($request->track_id);
        $playlist->tracks()->detach($track);
        return response()->json($playlist->tracks);
    }

    // Ver todas las canciones de una playlist
    public function getTracks($id)
    {
        $playlist = Playlist::findOrFail($id);

        $data = [
            'tracks' => $playlist->tracks,
        ];

        return response()->json($data);
    }
}

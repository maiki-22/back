<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Track;
use App\Models\Album;
use App\Models\Artist;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'error' => 'El parámetro de búsqueda "query" es requerido.'
            ], 400);
        }

        // Buscar en playlists
        $playlists = Playlist::where('name', 'LIKE', "%{$query}%")->get();

        // Buscar en tracks
        $tracks = Track::where('title', 'LIKE', "%{$query}%")->get();

        // Buscar en albums
        $albums = Album::where('title', 'LIKE', "%{$query}%")->get();

        // Buscar en artists
        $artists = Artist::where('name', 'LIKE', "%{$query}%")->get();

        // Buscar canciones y álbumes relacionados con los artistas encontrados
        $relatedTracks = collect();
        $relatedAlbums = collect();

        foreach ($artists as $artist) {
            $relatedTracks = $relatedTracks->merge(Track::where('artist_id', $artist->id)->get());
            $relatedAlbums = $relatedAlbums->merge(Album::where('artist_id', $artist->id)->get());
        }

        return response()->json([
            'playlists' => $playlists,
            'tracks' => $tracks,
            'albums' => $albums,
            'artists' => $artists,
            'related_tracks' => $relatedTracks,
            'related_albums' => $relatedAlbums,
        ]);
    }
}

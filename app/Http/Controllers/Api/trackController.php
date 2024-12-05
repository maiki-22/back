<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Track;

class TrackController extends Controller
{
    // Método para obtener todas las canciones
    public function getAll()
    {
        // Buscar todas las canciones
        $tracks = Track::all();

        // Validar si existen canciones
        if ($tracks->isEmpty()) {
            $data = [
                'message' => 'No se encontraron canciones',
                'status' => 200
            ];

            return response()->json($data, 404);
        }

        return response()->json($tracks, 200);
    }

    // Método para mostrar una canción
    public function show($id)
    {
        // Buscar la canción
        $track = Track::find($id);

        // Validar si existe la canción
        if (!$track) {
            $data = [
                'message' => 'No se encontró la canción',
                'status' => 200
            ];

            return response()->json($data, 404);
        }

        // Retornar la canción
        return response()->json($track, 200);
    }

    // Método para crear una canción
    public function create(Request $request)
    {
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|string',
            'artist_id' => 'required|integer',
            'album_id' => 'nullable|integer' // Opcional o nulo
        ]);

        // Si no pasa la validación, retorno un mensaje de error
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        // Si pasa la validación, creo la canción
        $track = Track::create($request->all());

        // Retorno mensaje
        $data = [
            'message' => 'Canción creada',
            'track' => $track,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    // Método para actualizar una canción
    public function update(Request $request, $id)
    {
        // Buscar la canción
        $track = Track::find($id);

        // Validar si existe la canción
        if (!$track) {
            $data = [
                'message' => 'No se encontró la canción',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        // Validar los datos
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'required',
            'album_id' => 'integer|nullable', // Opcional 
            'artist_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        // Actualizar la canción
        $track->title = $request->title;
        $track->image = $request->image;
        $track->album_id = $request->album_id;
        $track->artist_id = $request->artist_id;
        $track->save();

        // Retorno mensaje
        $data = [
            'message' => 'Canción actualizada',
            'track' => $track,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function delete($id)
    {
        // Buscar la canción
        $track = Track::find($id);

        // Validar si existe la canción
        if (!$track) {
            $data = [
                'message' => 'No se encontró la canción',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        // Eliminar la canción
        $track->delete();

        // Retorno mensaje
        $data = [
            'message' => 'Canción eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}

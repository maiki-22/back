<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\Validator;

class albumController extends Controller
{
    //metodo para listar todos los albumes
    public function getAll()
    {
        //busco todos los albumes
        $album = Album::all();
        //valido si existe
        if (!$album) {
            $data = [
                'message' => 'No se encontraron Albumes',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
        //retorno mensaje
        $data = [
            'message' => 'Listado de Albumes',
            'status' => 200
        ];
        return response()->json($album, 200);
    }

    //metodo para mostrar un album
    public function show($id)
    {
        //busco el album
        $album = Album::find($id);
        //valido si existe
        if (!$album) {
            $data = [
                'message' => 'No se encontró el Album',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
        //retorno el album
        return response()->json($album, 200);
    }
    //metodo para crear un album
    public function create(Request $request)
    {
        //valido los datos
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|string',
            'total_tracks' => 'required|integer',
            'artist_id' => 'required|integer'
        ]);
        //si no pasa la validación, retorno un mensaje de error
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        //si pasa la validación, creo el album
        $album = Album::create([
            'title' => $request->title,
            'image' => $request->image,
            'total_tracks' => $request->total_tracks,
            'artist_id' => $request->artist_id
        ]);

        //valida si se creo
        if (!$album) {
            $data = [
                'message' => 'Error al crear el Album',
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        //retorno mensaje
        $data = [
            'message' => 'Album creado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    //metodo para actualizar un album
    public function update(Request $request, $id)
    {
        //busco el album
        $album = Album::find($id);
        //valido si existe
        if (!$album) {
            $data = [
                'message' => 'No se encontró el Album',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
        //valido los datos
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|string',
            'total_tracks' => 'required|integer',
            'artist_id' => 'required|integer'
        ]);
        //si no pasa la validación, retorno un mensaje de error
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        //si pasa la validación, actualizo el album
        $album->title = $request->title;
        $album->image = $request->image;
        $album->total_tracks = $request->total_tracks;
        $album->artist_id = $request->artist_id;
        $album->save();
        //retorno mensaje
        $data = [
            'message' => 'Album actualizado correctamente',
            'album' => $album,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    //metodo para eliminar un album

    public function delete($id)
    {
        //busco el album
        $album = Album::find($id);
        //valido si existe
        if (!$album) {
            $data = [
                'message' => 'No se encontró el Album',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
        //en caso de ser encontrado, elimino el album
        $album->delete();
        //retorno mensaje
        $data = [
            'message' => 'Album eliminado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    //metodo para obtener todas las canciones de un album

    public function getTracks($id)
    {
        //busco el album
        $album = Album::find($id);
        //valido si existe
        if (!$album) {
            $data = [
                'message' => 'No se encontró el Album',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
        //obtengo las canciones del album
        $songs = $album->tracks;
        //valido si existen canciones
        if ($songs->isEmpty()) {
            $data = [
                'message' => 'No se encontraron canciones',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
        //retorno mensaje
        $data = [
            'tracks' => $songs,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}

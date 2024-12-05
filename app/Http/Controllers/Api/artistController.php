<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class artistController extends Controller
{
    // Metodo para listar todo los artistas
    public function getAll()
    {
        //busco todos los artistas
        $artist = Artist::all();
        //valido si existe
        if (!$artist) {
            $data = [
                'message' => 'No se encontraron Artistas',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
        //retorno mensaje
        $data = [
            'message' => 'Listado de Artistas',
            'status' => 200
        ];
        return response()->json($artist, 200);
    }

    // Metodo para crear un artista
    public function create(Request $request)
    {
        //valido los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:artist',
            'image' => 'required',
            'followers' => 'required|integer'
        ]);
        // si no pasa la validación, retorno un mensaje de error
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        // si pasa la validación, creo el artista
        $artist = Artist::create([
            'name' => $request->name,
            'image' => $request->image,
            'followers' => $request->followers
        ]);

        //valida si se creo
        if (!$artist) {
            $data = [
                'message' => 'Error al crear el Artista',
                'status' => 500
            ];
            return response()->json($data, 400);
        }
        // si se crea retrona al artista
        $data = [
            'message' => $artist,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    // Metodo para mostrar un artista
    public function show($id)
    {
        // busco el artista
        $artist = Artist::find($id);
        //valido si existe
        if (!$artist) {
            $data = [
                'message' => 'Artista no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        //retorno al artista
        
        return response()->json($artist, 200);
    }

    // Metodo para eliminar artista
    public function delete($id)
    {
        // busco el artista
        $artist = Artist::find($id);
        //valido si existe
        if (!$artist) {
            $data = [
                'message' => 'Error al eliminar el Artista',
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        //en caso de ser encontrado, elimino el artista
        $artist->delete();
        //retorno mensaje
        $data = [
            'message' => 'Artista eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    // Metodo para actualizar artista
    public function update(Request $request, $id)
    {
        // busco el artista
        $artist = Artist::find($id);
        //valido si existe
        if (!$artist) {
            $data = [
                'message' => 'Artista no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        //en caso de ser encontrado, valido los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'required',
            'followers' => 'required|integer'
        ]);
        // si no pasa la validación, retorno un mensaje de error
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        // si pasa la validación, actualizo los datos
        $artist->name = $request->name;
        $artist->image = $request->image;
        $artist->followers = $request->followers;
        // guardo los cambios
        $artist->save();

        $data = [
            'message' => 'Artista actualizado',
            'artist' => $artist,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    // Metodo para obtener las canciones de un artista
    public function getTracks($id)
    {
        // busco el artista
        $artist = Artist::find($id);
        //valido si existe
        if (!$artist) {
            $data = [
                'message' => 'Artista no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        // obtengo las canciones del artista
        $tracks = $artist->tracks;
        //retorno las canciones
        $data = [
            'tracks' => $tracks,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    // Metodo para obtener los albumes de un artista
    public function getAlbums($id)
    {
        // busco el artista
        $artist = Artist::find($id);
        //valido si existe
        if (!$artist) {
            $data = [
                'message' => 'Artista no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        // obtengo los albumes del artista
        $albums = $artist->albums;
        //retorno los albumes
        $data = [
            'message' => 'Listado de Albumes',
            'albums' => $albums,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}

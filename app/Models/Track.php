<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Album;
use App\Models\Artist;

class Track extends Model
{
    use HasFactory;

    protected $table = 'track';

    protected $fillable = [
        'title',
        'image',
        'album_id',
        'artist_id'
    ];

    // Relación - una canción pertenece a un álbum (opcional)
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // Relación - una canción pertenece a un artista
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
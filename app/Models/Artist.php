<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Album;
use App\Models\Track;

class Artist extends Model
{
    use HasFactory;

    protected $table = 'artist';
    
    protected $fillable = [
        'name',
        'image',
        'followers'
    ];

    //relacion - un artista tiene muchos albumes
    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    //relacion - un artista tiene muchas canciones
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }


}
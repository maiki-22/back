<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlist';

    protected $fillable = [
        'name',
        'image',
    ];
    //RELACION MUCHOS A MUCHOS
    public function tracks()
    {
        return $this->belongsToMany(Track::class);
    }
}

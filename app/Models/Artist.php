<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    public function albums()
    {
        // album.artist_id is the foreign key column
        return $this->hasMany(Album::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    public function album()
    {
        //whenever you have foreign key and you have 1-to-many relationship, it's belongsTo
        return $this->belongsTo(Album::class);
    }
}

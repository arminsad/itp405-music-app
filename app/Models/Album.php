<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Artist;

class Album extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'artist_id'];

    public function artist()
    {
        // album.artist_id is FK column
        return $this->belongsTo(Artist::class);
    }

    public function user()
    {
        // album.artist_id is FK column
        return $this->belongsTo(User::class);
    }
}

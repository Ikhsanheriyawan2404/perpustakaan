<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['publish_year', 'publisher', 'author', 'price', 'title', 'isbn', 'image', 'quantity', 'description', 'booklocation_id'];

    public function booklocation()
    {
        return $this->belongsTo(Booklocation::class);
    }


    public function bookloan()
    {
        return $this->hasMany(Bookloan::class);
    }

    public function getTakeImageAttribute()
    {
        return '/storage/' . $this->image;
    }
}

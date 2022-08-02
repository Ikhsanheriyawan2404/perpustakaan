<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'quantity', 'description', 'booklocation_id'];

    public function booklocation()
    {
        return $this->belongsTo(Booklocation::class);
    }

    public function getTakeImageAttribute()
    {
        return '/storage/' . $this->image;
    }
}

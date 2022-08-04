<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

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

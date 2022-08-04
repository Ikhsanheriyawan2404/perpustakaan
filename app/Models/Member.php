<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'gender', 'email', 'phone_number', 'image', 'address', 'status'];

    public function bookloan()
    {
        return $this->hasMany(Bookloan::class);
    }

    public function getTakeImageAttribute()
    {
        return '/storage/' . $this->image;
    }
}

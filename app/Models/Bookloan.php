<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bookloan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['admin', 'status', 'credit_code', 'borrow_date', 'date_of_return', 'member_id', 'book_id'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}

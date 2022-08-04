<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;

class BooksExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::get(['title', 'author', 'publisher', 'publish_year', 'isbn', 'quantity', 'price', 'description', 'booklocation_id']);
    }
}

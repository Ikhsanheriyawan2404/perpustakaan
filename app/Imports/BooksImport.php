<?php

namespace App\Imports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BooksImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // $booklocation = Booklocation::where('id', $row[7])->first();
            $book = Book::create([
                'title' => $row[1],
                'author' => $row[2],
                'publisher' => $row[3],
                'publish_year' => $row[4],
                'isbn' => $row[5],
                'quantity' => $row[6],
                'booklocation_id' => rand(1, 5),
                // 'price' => $row[8],
                // 'description' => $row[9],
            ]);
        }
    }
}

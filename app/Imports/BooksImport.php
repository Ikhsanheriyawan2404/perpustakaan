<?php

namespace App\Imports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;

class BooksImport implements ToCollection, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // if ($row[7] === null || $row[8] === null) {
            //     return null;
            // }
            Book::create([
                'title' => $row[0],
                'author' => $row[1],
                'publisher' => $row[2],
                'publish_year' => $row[3],
                'isbn' => $row[4],
                'quantity' => $row[5],
                'price' => $row[6],
                'description' => $row[7],
                'booklocation_id' => $row[8],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '0' => 'required|max:255',
            '1' => 'nullable|max:255',
            '2' => 'nullable|max:255',
            '3' => 'nullable|max:255',
            '4' => 'nullable|max:255',
            '6' => 'nullable|max:255',
            '7' => 'nullable',
            '8' => 'required|max:255',
        ];
    }
}

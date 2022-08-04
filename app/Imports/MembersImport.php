<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;

class MembersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Member([
            'name' => $row[0],
            'gender' => $row[1],
            'email' => $row[2],
            'phone_number' => $row[3],
            'address' => $row[4],
        ]);
    }
}

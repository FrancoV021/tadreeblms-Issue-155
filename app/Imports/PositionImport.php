<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Position;
use Maatwebsite\Excel\Concerns\ToModel;

class PositionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Position([
            //
        ]);
    }
}

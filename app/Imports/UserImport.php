<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
class UserImport implements ToModel,  WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

      public function model(array $row)
    {


        // return dd($row);

        return new User([
            'user_name'        => $row['employee_id'],
            'name'             => $row['employee_name'], 
            'designation'      => $row['designation'], 
            'department_id'    => $row['department_id'], 
            'unit_id'          => $row['unit_id'], 
            'location_id'      => $row['location_id'], 
            'email'            => $row['employee_email'], 
            'password'         => Hash::make($row['password'])
        ]);
    }
}

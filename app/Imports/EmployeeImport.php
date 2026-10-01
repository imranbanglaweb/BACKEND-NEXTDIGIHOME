<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel,  WithHeadingRow
{
 

      public function model(array $row)
    {
        // dd($row[0][2]);
        return new Employee([
            'employee_id'     => $row['employee_id'],
            'employee_name'   => $row['employee_name'], 
            'gender'          => $row['gender'], 
            'employee_email'  => $row['employee_email'], 
            'department_head' => $row['department_head'], 
            'department_id'   => $row['department_id'], 
            'location_id'     => $row['location_id'], 
            'unit_id'         => $row['unit_id'], 
            'designation'     => $row['designation'], 
        ]);
    }
}

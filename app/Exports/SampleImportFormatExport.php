<?php

namespace App\Exports;

use App\Models\ImportFile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class SampleImportFormatExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return ImportFile::all();
    // }


     public function array(): array
    {
        // Define the structure of the sample Excel file
        return 
          [ 
          	[   'department_id',
	         	'module_id',	
	         	'particular_id',	
	         	'quantity',	
	         	'employee_id',
	         	'task_channel',
	         	'task_start_date',
	         	'task_due_date',
	         	'priority',
	         	'work_status',
	         	'task_details',	
	         	'task_remarks'
                     
                  ]
           ];
    }
}

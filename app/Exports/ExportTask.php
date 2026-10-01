<?php

namespace App\Exports;

// use App\Models\Landinventory;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
Use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExportTask implements FromCollection, WithHeadings, WithTitle
{
    use Exportable;
    protected $data;

    function __construct($data) {

        $this->data=$data;
        
       // dd($this->data);
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        // dd('exit');
       
        $support_details  = DB::table('issue_registers')
      ->select(
        'issue_registers.task_id',
        'users.name',
        'categories.category_name',
        'tasktitles.task_title',
        'issue_registers.quantity',
        'issue_registers.task_start_date',
        'issue_registers.task_due_date',
        'issue_registers.task_completed_date',
        'issue_registers.issue_type_id',
        'issue_registers.issue_status',
        'employees.employee_name',
        'issue_registers.remarks',
      )
        ->leftJoin('employees','employees.id','issue_registers.assigned_to')
        // ->leftJoin('issue_registers','issue_registers.id','supportdetails.support_id')
        ->leftJoin('categories','categories.id','issue_registers.category_id')
        ->leftJoin('users','users.id','issue_registers.assign_task_status')
        // ->leftJoin('support_types','support_types.id','supportdetails.support_type_id')
        ->leftJoin('tasktitles','tasktitles.id','issue_registers.title')
        ->orderBy('issue_registers.id','desc')
        // ->where('supportdetails.support_id',$id)
        ->get();
       
        return $support_details;
    
    }

    public function headings(): array
    {

        return [
            'Task Id',
            'Raised By',
            'Category Name',
            'Title',
            'Quantity',
            'Task Start Date',       
            'Task End Date',       
            'Completed Date',        
            'Task Priority',        
            'Task Status',        
            'Task Assigned',        
            'Remarks'        
        ];
    }
    
   public function title(): string
    {
       
        return 'Task List';
    }
   
}

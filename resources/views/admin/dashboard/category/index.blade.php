@extends('admin.dashboard.master')


@section('main_content')
<style>
  #menu_list {
  padding: 0px;
}
#menu_list td {
  list-style: none;
  margin-bottom: 10px;
  border: 1px solid #d4d4d4;
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
      border-color: #D4D4D4 #D4D4D4 #BCBCBC;
      padding: 6px;
      cursor: move;
      background: #f6f6f6;
      background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #ededed 100%);
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(47%,#f6f6f6), color-stop(100%,#ededed));
      background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
      background: -o-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
      background: -ms-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
      background: linear-gradient(to bottom,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 );
}
.myDiv{
  display:none;
    padding:10px;
    margin-top:20px;
}
</style>

<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Category Manage</h2><br>
        </div>
        <div class="pull-right">
        @can('task-entry')
            <a class="btn btn-success" href="{{ route('categories.create') }}"> 
              <i class="fa fa-plus"></i>   
               Add Category
              </a>
            @endcan
        </div>
    </div>

    <div class="col-lg-4">
      <div>
                <select class="form-control select_employee_file">
                  <option>Select Employee Export/Import</option>
                  <option value="Import">Import</option>
                  <option value="Export">Export</option>
                </select>
              </div>
          
<br>
  <div id="showImport" class="myDiv">
           <form action="{{ route('category.import-category')}}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
              <input type="file" name="file" required=""><br>
               <button class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i> Import  </button>
           </form>
          </div>
         
          <br>
          <div id="showExport" class="myDiv">
              <form  method="POST" action="{{ route('employee.export')}}" enctype="multipart/form-data">
                 <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
              <button class="btn btn-success"><i></i> <i class="fa fa-file-excel-o" aria-hidden="true"></i>  Export
            </button>
             </form>
          </div>
{{-- 
        @can('department-head')
           <div class="col-md-4">
             <select class="form-control select2 location_list">
               <option>Select Location</option>

               @foreach($location_lists as $location_list)
                    <option value="{{ $location_list->id}}">{{ $location_list->location_name}}</option>
               @endforeach
             </select>
           </div>
           <div class="col-md-4">
             <select class="form-control department_list">
               <option>Select Department</option>
             </select>
           </div>
           <div class="col-md-4">
              <select class="form-control user_list" name="created_by">
               <option value="">Select User</option>
             </select>
           </div>
        @endcan --}}
     <br>
     <br>
    </div>
</div>


@if ($message = Session::get('success'))
    <div class="alert alert-success myElem">
        <p>{{ $message }}</p>
    </div>
@endif
@if ($message = Session::get('danger'))
    <div class="alert alert-danger myElem">
        <p>{{ $message }}</p>
    </div>
@endif


<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>
    </header>
    <div class="panel-body">
    <table class="table table-bordered table-striped mb-none user_datatable" id="user_datatable">
<thead>
  <tr>
     <th width="1%">SL</th>
     <th width="30%">Category Name</th>
     <th>Department</th>
     <th width="15%">Action</th>
  </tr>
</thead>
  <tbody class="">
  </tbody>
</table>
</section>
</div>
</div>
</div>
</section>

</section>

{{-- modal change status--}}
<div class="modal modal-danger fade" tabindex="-1" id="change_status_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="md-close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa fa-eye"></i> Change Issue Status
                </h4>
            </div>
            <div class="modal-body" id="delete_model_body"></div>
            <div class="modal-footer">
              
              <form method="POST" action="" id="changed_status">
                
{{-- {!! Form::open(array('method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'changed_status')) !!} --}}
                     <div class="form-group">
                        <input type="hidden" name="issue_id" class="id">
                        <input type="hidden" name="category_id" class="category_id">
                        <input type="hidden" name="issue_come_from" class="issue_come_from">
                        <input type="hidden" name="issue_type_id" class="issue_type_id">
                        <input type="hidden" name="assign_task_status" class="assign_task_status">
                        <input type="hidden" name="support_type_id" class="support_type_id">
                        
                          <select class="form-control issue_status" name="issue_status">
                             <option value=""><strong>Select Support Status </strong></option>
                             <option value="Ongoing">Ongoing</option>
                             <option value="Pending">Pending</option>
                             <option value="Completed">Completed</option>
                          {{-- <option></option> --}}
                         
                          </select>
                    </div>
                    <br>
                    <div class="form-group">
                        
                        <textarea class="form-control remarks" name="remarks" val=""></textarea>
                    </div>
                  <br>
                   
                    <fieldset class="">
                       <label for="send_email">Send Email To Others?
                       <input class="send_email" type="checkbox" name="send_email" value="1" />
                        </label>
                     </fieldset>

                       <fieldset class="show_div">
                           {{-- <label for="coupon_field">Email Address:</label> --}}
                           <input type="email" class="form-control email_to_others" name="email_to_others" id="show_div" placeholder="Enter Email Address" />
                       </fieldset>
                        <br>
                   
            {{--         <button  class="btn btn-danger pull-right delete-confirm changed_status"
                           value="Change Status">Change Status</button> --}}
                            <button style="float: left;" id="saveBtn" class="btn btn-primary text-left btn-submit">Update Status</button>
                            <br>
                   </form>
                   <br>
                <button type="button" class="btn btn-default pull-right"
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>

{{-- modal details VIew--}}

<div class="modal modal-success fade" tabindex="-1" id="assign_task_modal" role="dialog" style="width: 100% !important">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="md-close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa fa-eye"></i> Assign Task To User
                </h4>
            </div>
            <div class="modal-body" id="delete_model_body"></div>
            <div class="modal-footer">
              

  <form method="POST" action="" id="assign_task_form">
                
{{-- {!! Form::open(array('method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'changed_status')) !!} --}}
                     <div class="form-group">
                    <input type="hidden" name="issue_register_id" class="id">
                        
                          <select class="form-control user_list_assigned" name="user_task_id">
                           
                          {{-- <option></option> --}}
                    
                          </select>
                    </div>
                    <br>

                   <div class="form-group">
                        
                        <textarea class="form-control remarks" name="remarks" placeholder="Enter Remarks"></textarea>
                    </div>
                    <br>
            {{--         <button  class="btn btn-danger pull-right delete-confirm changed_status"
                           value="Change Status">Change Status</button> --}}
                            <button id="addtask" class="btn btn-primary text-left addtask"><i class="fa fa-plus"></i>&nbsp;Add Task</button>
                            <br>
                           
                   </form>
                   <br>
                <button type="button" class="btn btn-default pull-right"
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- modal Utask Details view--}}
<div class="modal modal-danger fade" tabindex="-1" id="view_details_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="md-close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa fa-eye"></i> Task Details
                </h4>
            </div>
            <div class="modal-body" id="delete_model_body">
              
          <div class="row">
            <div class="col-md-7">
              <table class="display table">
                <tr>
                  <td>Task ID</td>
                  <td><p id="task_id"></p></td>
                </tr>  
                <tr>
                   <td>Cat Name</td>
                    <td><p id="category_name"></p></td>
                </tr>
                <tr>
                   <td>Task Title</td>
                    <td><p id="title"></p></td>
                </tr> 
              
                <tr>
                  <td>Task Status</td>
                    <td><p id="issue_type_id"></p></td>
                  
                </tr> 
                <tr>
                  <td>Task Details</td>
                  <td><p id="task_details"></p></td>
                </tr> 
                <tr>
                  <td>Task Remarks</td>
                  <td><p id="task_remarks"></p></td>
                </tr>             
              </table>
            </div>
            <div class="col-md-5">
              
              <h4 style="color: skyblue"><strong>Assign Task</strong></h4>

              <p id="assign_task_to_employee"></p>
              <p id="task_start_date" class="task_start_date_icon">
               </p>
              <p id="task_due_date" class="task_due_date_icon"></p>
                 <p><p id="task_priority"></p>
                  
                </tr>
            </div>
          </div>
            </div>
            <div class="modal-footer">
              
         
                   <br>
                <button type="button" class="btn btn-default pull-right"
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>

{{-- <script  src="{{ asset('js/')}}/function.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="{{ asset('public/admin_resource/assets/js/validation.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<script>
// In your Javascript (external.js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2();


});
</script>
<script type="text/javascript">
  

  $(function () {


// location wise department list

$(".location_list").change(function () {
             var location_id = $(this).val();

            // alert(location_id);

            $.ajax({
                type: 'GET',
                url: "{{ route('location-wise-department-list')}}",
                data: { location_id},
// alert(JSON.stringify(data));
                dataType: 'json',
                success: function (data) {     
                // alert(data); 
        $(".department_list").empty();

        $('.department_list').prepend("<option value=''>" +'Please Select'+"</option>");
           $.each(data['department_list'], function (key, department_list) {

            $('.department_list').append("<option   value='" + department_list.id + "'>" + department_list.department_name +"</option>");

                    });

           
                },
                error: function (_response) {
                    alert("error");
                }

            });

    });

// end 

    var table = $('.user_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('categories.index') }}",
          data: function (d) {
                d.created_by = $('.user_list').val();
                //d.search = $('input[type="search"]').val()
                // d.search = $('input[type="search"]').val()
                // d.search = $('input[type="search"]').val()
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'category_name',   name: 'category_name'},
            {data: 'category_name',   name: 'category_name'},
            // {data: 'category_name',   name: 'category_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

 $(".user_list").change(function(){
   // var department_id = $(this).val();
   // alert(department_id);
        table.draw();
    });
// end data table load for details


    $(".myElem").show().delay(5000).fadeOut();
    $(function(){
      $("#menu_list").sortable({
        stop: function(){
          $.map($(this).find('tr'), function(el) {
            var itemID = el.id;
            var itemIndex = $(el).index();
            // alert(itemIndex);
            $.ajax({
              url:'{{URL::to("order-menu")}}',
              type:'GET',
              dataType:'json',
              data: {itemID:itemID, itemIndex: itemIndex},
            })
          });
        }
      });
    });

  });
  </script>
    <script>

$(document).on('click','.deleteUser',function(e){
    e.preventDefault();
    var q_id = $(this).data('qid');
    var deleteUrl = '{{ route("categories.destroy", ":id") }}'.replace(':id', q_id);
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    Swal.fire({
        title: 'Are you sure?',
        text: 'This category will be permanently deleted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(res) {
                    Swal.fire('Deleted!', res.message || 'Category deleted successfully.', 'success');
                    $('.user_datatable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Delete failed', 'error');
                }
            });
        }
    });
});


$(document).ready(function(){


    $('.select_employee_file').on('change', function(){
      var demovalue = $(this).val(); 
      // alert(demovalue);
        $(".myDiv").hide();
        $("#show"+demovalue).show();
    });
});
</script>
  <script>
  @if(Session::has('message'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.error("{{ session('error') }}");
  @endif

  @if(Session::has('info'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.info("{{ session('info') }}");
  @endif

  @if(Session::has('warning'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.warning("{{ session('warning') }}");
  @endif
</script>
@endsection
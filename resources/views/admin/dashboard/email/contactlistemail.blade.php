<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<style type="text/css">
	th{
		padding: 10px
	}
	thead{
		background-color: #0088cc;
		color: #fff;
		padding: 10px
	}
	tr,td,thead,th{
		border: 1px solid #666;
		text-align: center;
		padding: 5px
	}
	table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}
th, td {
  text-align: left;
  /*padding: 8px;*/
}
</style>
</head>
<body>
@php 
Use \Carbon\Carbon;
@endphp
<div style="overflow-x:auto;">
<table style="width: 100%; border: 1px solid #000">
	<thead>
		<tr>
			<th width="15%">Task Id</th>
			<th>Issue Come From</th>
			<th>Issue Date</th>
			<th>Task Details</th>
			{{-- <th>Assign By</th> --}}
			<th>Completion Date</th>
			<th>Status</th>
			<th>Remarks</th>
		</tr>
	</thead>
		<tbody>
			@foreach($task_details as $list)
			<tr>
				<td> {{ $list->task_id}}</td>
				<td style="text-align: left !important;"> 
					{{ $list->emp_id }}<br>
					{{ $list->employee_name }}<br>
					{{ $list->designation }}<br>
{{-- 					{{ $list->department_name }}<br>
					{{ $list->unit_name }}<br>
					{{ $list->employee_email }}<br> --}}
				</td>
				<td>
					{{-- {{ $task_details['issue_date'] }} --}}
				
				   {{ Carbon::createFromFormat('Y-m-d H:i:s', $list->issue_date)->format('d M y')}}
				  </td>
				<td>{{ $list->task_details }}</td>
				{{-- <td>{{ $list->name}}</td> --}}
				<td>
					 @if(!empty($list->task_completed_date))
{{ Carbon::createFromFormat('Y-m-d H:i:s', $list->task_completed_date)->format('d M y')}}
					 @else
					
					 @endif
				</td>
				<td>{{ $list->support_status }}</td>
				<td>{{ $list->Remarks }}</td>
			</tr>
			@endforeach
		</tbody>

	<tr>
<td colspan="8">

{{-- <h2 style="font-weight: 200; font-size: 16px; margin: 20px 0; color: #333333;"> [YOURFIELD] </h2> --}}
{{-- <h2 style="font-weight: 200; font-size: 16px; margin: 20px 0; color: #333333;"> [YOURFIELD] </h2>
<h2 style="font-weight: 200; font-size: 16px; margin: 20px 0; color: #333333;"> [YOURFIELD] </h2>
<h2 style="font-weight: 200; font-size: 16px; margin: 20px 0; color: #333333;"> [YOURFIELD] </h2> --}}
<p style="text-align: center; display: block; padding-top:10px; font-weight: bold; margin-top:10px; color: #666666; border-top:1px solid #dddddd;">Ticketing System</p><br>
<p style="text-align: center;">Copyright ©2023 All rights reserved | developed  by Unique Group IT</p>
</td>
</tr>
</table>
<div>

</body>
</html>
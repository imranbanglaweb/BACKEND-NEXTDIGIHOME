<?php

namespace App\Http\Controllers;

use App\Models\Licnese_type;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LicneseTypeController extends Controller
{
    // INDEX VIEW
    public function index()
    {
        return view('admin.dashboard.license_types.index');
    }

    // DATATABLES SERVER-SIDE
    public function data()
    {
        $query = Licnese_type::select(['id', 'type_name', 'description', 'status', 'created_at'])->orderBy('id', 'desc');

        return DataTables::of($query)
            ->addIndexColumn() // DT_RowIndex
            ->editColumn('status', function ($row) {
                return $row->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($row) {
                return '
                    <button class="btn btn-sm btn-primary editBtn" data-id="' . $row->id . '"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $row->id . '"><i class="fa fa-minus-circle"></i></button>
                ';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    // STORE NEW LICENSE TYPE
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:191|unique:licnese_types,type_name',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['type_name', 'description']);
        $data['status'] = $request->status ?? 1;
        $data['created_by'] = auth()->id() ?? 1;

        $type = Licnese_type::create($data);

        return response()->json([
            'success' => true,
            'message' => 'License type created successfully',
            'data' => $type
        ]);
    }

    // EDIT - GET DATA FOR MODAL
    public function edit($id)
    {
        $type = Licnese_type::findOrFail($id);
        return response()->json($type);
    }

    // UPDATE LICENSE TYPE
    public function update(Request $request, $id)
    {
        $type = Licnese_type::findOrFail($id);

        $request->validate([
            'type_name' => 'required|string|max:191|unique:licnese_types,type_name,' . $type->id,
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1'
        ]);

        $data = $request->only(['type_name', 'description', 'status']);
        $data['updated_by'] = auth()->id() ?? 1;

        $type->update($data);

        return response()->json([
            'success' => true,
            'message' => 'License type updated successfully',
            'data' => $type
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $type = Licnese_type::findOrFail($id);
        $type->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully'
        ]);
    }
}

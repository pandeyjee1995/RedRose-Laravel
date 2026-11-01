<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\SchoolClassesModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class SchoolClassesController extends Controller
{

	public function storeData(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Class created successfully'
        ]);
    }


    // Get all classes
    public function index(Request $request)
    {
        // $classes = SchoolClassesModel::orderBy('id', 'asc')->get();

        $perPage = (int) $request->input('per_page', 10);

        $perPage = max(1, min($perPage, 100));
// echo"kjkk";exit;
       

$classes = DB::table('school_classes as sc')
    ->leftJoin('users as u', 'sc.created_by', '=', 'u.id')
    ->select(
        'sc.*',
        'u.name as user_name',
        'u.email as user_email'
    )
    ->when($request->filled('class_name'), function ($query) use ($request) {
        $query->where(
            'sc.class_name',
            'LIKE',
            '%' . $request->input('class_name') . '%'
        );
    })
    ->when($request->filled('class_code'), function ($query) use ($request) {
        $query->where(
            'sc.class_code',
            'LIKE',
            '%' . $request->input('class_code') . '%'
        );
    })
    ->when($request->filled('status'), function ($query) use ($request) {
        $query->where('sc.status', $request->input('status'));
    })
    ->when($request->filled('created_by'), function ($query) use ($request) {
        $query->where('sc.created_by', $request->input('created_by'));
    })
    ->orderBy('sc.id', 'asc')
    ->paginate($perPage)
    ->withQueryString();

        return response()->json([
            'success' => true,
            'message' => 'School classes retrieved successfully',
            'data' => $classes->items(),
            'pagination' => [
                'current_page' => $classes->currentPage(),
                'per_page' => $classes->perPage(),
                'total' => $classes->total(),
                'last_page' => $classes->lastPage(),
                'from' => $classes->firstItem(),
                'to' => $classes->lastItem(),
                'has_more_pages' => $classes->hasMorePages(),
            ],
            'reqData' => $request->all(),
        ]);
    }

    // // Get single class
    public function showOneClasses($id)
    {
        // $class = SchoolClassesModel::find($id);
        $class = SchoolClassesModel::leftJoin(
            'users',
            'school_classes.created_by',
            '=',
            'users.id'
        )
        ->select(
            'school_classes.*',
            'users.name as user_name',
            'users.email as user_email'
        )
        ->where('school_classes.id', $id)
        ->first();


        if (!$class) {
            return response()->json([
                'success' => false,
                'message' => 'School class not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'School class retrieved successfully',
            'data' => $class
        ]);
    }

    // Create class
    public function store(Request $request)
    {
    
        $validated = Validator::make($request->all(), [
            'class_name' => 'required|string|max:255',
            'class_code' => 'required|string|max:50|unique:school_classes,class_code',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);
	
        // $class = SchoolClassesModel::create($validated);
        $class = SchoolClassesModel::create([
            'class_name'  => $request->class_name,
            'class_code'  => $request->class_code,
            'description' => $request->description,
            'created_by'  => 1,
            'status'      => $request->status,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'School class created successfully',
            'data' => $class
        ], 201);
    }

    // Update class
    public function update(Request $request, $id)
    {
        $class = SchoolClassesModel::find($id);

        if (!$class) {
            return response()->json([
                'success' => false,
                'message' => 'School class not found'
            ], 404);
        }

        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            // 'code' => 'required|string|max:50|unique:school_classes,code,' . $id,
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $class->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'School class updated successfully',
            'data' => $class
        ]);
    }

    // // Delete class
    public function deleteClasses(Request $request, $id)
    {
        $class = SchoolClassesModel::find($id);

        if (!$class) {
            return response()->json([
                'success' => false,
                'message' => 'School class not found'
            ], 404);
        }

        $validated = $request->validate([
            'status' => 'nullable|boolean',
        ]);

        $class->update($validated);
        // $class->delete();

        return response()->json([
            'success' => true,
            'message' => 'School class deleted successfully'
        ]);
    }
}

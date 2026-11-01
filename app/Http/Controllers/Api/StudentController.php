<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(
        private StudentService $studentService
    ) {
    }

    /**
     * Student list
     */
    public function index(Request $request)
    {
        $students = $this->studentService->getAll(
            $request->only([
                'status',
                'class_id',
            ])
        );

        return response()->json([
            'success' => true,
            'message' => 'Students retrieved successfully.',
            'data' => $students,
        ]);
    }

    /**
     * Create student
     */
    public function store(StoreStudentRequest $request)
    {
    	// print_r($request);exit;
    	$data = $request->validated();

	    // if ($request->hasFile('photo')) {
	    //     $data['photo'] = $request
	    //         ->file('photo')
	    //         ->store('students', 'public');
	    // }
	    // exit;
        $student = $this->studentService->create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully.',
            'data' => $student->load('schoolClass'),
        ], 201);
    }

    /**
     * Student details
     */
    public function show($id)
    {
        $student = $this->studentService->findById($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Student retrieved successfully.',
            'data' => $student,
        ]);
    }

    /**
     * Update student
     */
    public function update(UpdateStudentRequest $request, $id) {
        $student = $this->studentService->findById($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.',
                'data' => null,
            ], 404);
        }

        $student = $this->studentService->update(
            $student,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully.',
            'data' => $student,
        ]);
    }

    /**
     * Delete student
     */
    public function destroy($id)
    {
        $student = $this->studentService->findById($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.',
            ], 404);
        }

        $this->studentService->delete($student);

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully.',
            'data' => null,
        ]);
    }

    /**
     * Update student status
     */
    public function updateStatus(Request $request, $id) {
        $request->validate([
            'status' => [
                'required',
                'boolean',
            ],
        ]);

        $student = $this->studentService->findById($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.',
            ], 404);
        }

        $student = $this->studentService->update(
            $student,
            [
                'status' => $request->boolean('status'),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Student status updated successfully.',
            'data' => $student,
        ]);
    }
}
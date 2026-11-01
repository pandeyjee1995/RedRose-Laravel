<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function __construct(
        private TeacherService $teacherService
    ) {}

    // GET: Teacher list
    public function index(Request $request)
    {
         $request->validate([
            'status'   => ['sometimes', 'nullable', 'in:0,1'],
            'search'   => ['sometimes', 'nullable', 'string', 'max:100'],
            'page'     => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $teachers = $this->teacherService->getAll(
            $request->only(['status', 'search', 'per_page'])
        );

    
        // $teachers = $this->teacherService->getAll(
        //     $request->only(['status', 'search'])
        // );

        return response()->json([
            'success' => true,
            'message' => 'Teachers retrieved successfully.',
            'data' => $teachers->items(),
            'pagination' => [
                'current_page' => $teachers->currentPage(),
                'per_page'     => $teachers->perPage(),
                'total'        => $teachers->total(),
                'last_page'    => $teachers->lastPage(),
                'from'         => $teachers->firstItem(),
                'to'           => $teachers->lastItem(),
                'has_more_pages' => $teachers->hasMorePages(),
            ],
        ]);
    }

    // POST: Create teacher
    public function store(StoreTeacherRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                ->store('teachers', 'public');
        }

        $teacher = $this->teacherService->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Teacher created successfully.',
            'data' => $teacher,
        ], 201);
    }

    // GET: Single teacher
    public function show($id)
    {
        $teacher = $this->teacherService->findById($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Teacher retrieved successfully.',
            'data' => $teacher,
        ]);
    }

    // PUT: Update teacher
    public function update(UpdateTeacherRequest $request, $id)
    {
        $teacher = $this->teacherService->findById($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found.',
            ], 404);
        }

        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }

            $data['photo'] = $request->file('photo')
                ->store('teachers', 'public');
        }

        $teacher = $this->teacherService->update($teacher, $data);

        return response()->json([
            'success' => true,
            'message' => 'Teacher updated successfully.',
            'data' => $teacher,
        ]);
    }

    // DELETE: Delete teacher
    public function destroy($id)
    {
        $teacher = $this->teacherService->findById($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found.',
            ], 404);
        }

        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }

        $this->teacherService->delete($teacher);

        return response()->json([
            'success' => true,
            'message' => 'Teacher deleted successfully.',
            'data' => null,
        ]);
    }

    // PUT: Update teacher status
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        $teacher = $this->teacherService->findById($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found.',
            ], 404);
        }

        $teacher = $this->teacherService->update($teacher, [
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher status updated successfully.',
            'data' => $teacher,
        ]);
    }
}
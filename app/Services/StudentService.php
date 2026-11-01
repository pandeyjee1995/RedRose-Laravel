<?php

namespace App\Services;

use App\Models\Api\StudentModel;
use Illuminate\Database\Eloquent\Collection;

class StudentService
{
    public function getAll(array $filters = []): Collection
    {
        $query = StudentModel::with('schoolClass')
            ->latest();

        if (!empty($filters['status'])) {
            $query->where(
                'status',
                $filters['status']
            );
        }

        if (!empty($filters['class_id'])) {
            $query->where(
                'class_id',
                $filters['class_id']
            );
        }

        return $query->get();
    }

    public function findById(int $id): ?StudentModel
    {
        return StudentModel::with('schoolClass')
            ->find($id);
    }

    public function create(array $data): StudentModel
    {
        return StudentModel::create($data);
    }

    public function update(
        StudentModel $student,
        array $data
    ): StudentModel {
        $student->update($data);

        return $student->fresh('schoolClass');
    }

    public function delete(StudentModel $student): bool
    {
        return $student->delete();
    }
}
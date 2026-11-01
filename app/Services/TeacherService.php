<?php

namespace App\Services;

use App\Models\Api\TeacherModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TeacherService
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = TeacherModel::query()->latest();

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('employee_id', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->paginate(15);
    }

    public function findById(int $id): ?TeacherModel
    {
        return TeacherModel::find($id);
    }

    public function create(array $data): TeacherModel
    {
        return TeacherModel::create($data);
    }

    public function update(TeacherModel $teacher, array $data): TeacherModel
    {
        $teacher->update($data);

        return $teacher->fresh();
    }

    public function delete(TeacherModel $teacher): bool
    {
        return $teacher->delete();
    }
}
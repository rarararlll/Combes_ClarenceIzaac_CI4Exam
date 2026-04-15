<?php

namespace App\Controllers\Api;

use App\Models\UserModel;

class StudentsController extends BaseApiController
{
    // GET /api/v1/students
    public function index()
    {
        $model = new UserModel();
        
        // Fetch all users (since this is for a screenshot, findAll is safest)
        $students = $model->findAll();

        if (empty($students)) {
            return $this->respondFail('No student records found.', 404);
        }

        return $this->respondSuccess($students, 'Student list retrieved successfully.');
    }

    // GET /api/v1/students/{id}
    public function show($id = null)
    {
        if (! $id) {
            return $this->respondFail('Please provide a student ID.', 400);
        }

        $model = new UserModel();
        // Use find($id) instead of the missing getStudentById()
        $student = $model->find($id);

        if (! $student) {
            return $this->respondFail('No student found with that ID.', 404);
        }

        return $this->respondSuccess($student, 'Student record retrieved.');
    }
}

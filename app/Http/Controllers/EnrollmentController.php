<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enrollment\GradeEnrollmentRequest;
use App\Models\ApiResponse;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Course $course)
    {
        $student = $request->user();

        $student->courses()->attach($course);

        return ApiResponse::success('Enrollment created successfully', [
            'course' => $course,
            'student' => $student,
        ]);
    }

    public function destroy(Request $request, Course $course)
    {
        $request->user()->courses()->detach($course);

        return ApiResponse::success('Enrollment deleted successfully');
    }

    public function gradeEnrollment(GradeEnrollmentRequest $request, Enrollment $enrollment)
    {
        $request->validated();

        $enrollment->update($request->only(['grade']));

        return ApiResponse::success('Enrollment graded successfully', [
            'enrollment' => $enrollment
        ]);
    }

    public function storeStudent(Course $course, User $student)
    {
        $this->authorize('checkOwnership', $course);

        if ($student->courses->contains($course))
        {
            return ApiResponse::error('Student already enrolled in this course');
        }

        $student->courses()->attach($course);

        return ApiResponse::success('Student enrollment added successfully', [
            'course' => $course,
            'student' => $student
        ]);
    }

    public function destroyStudent(Course $course, User $student)
    {
        $this->authorize('checkOwnership', $course);

        $student->courses()->detach($course);

        return ApiResponse::error('Student enrollment deleted successfully');
    }
}

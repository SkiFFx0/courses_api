<?php

namespace App\Http\Controllers;

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
        $request->user()->courses()->attach($course);

        return response()->json([
            'message' => 'Enrollment created successfully'
        ]);
    }

    public function destroy(Request $request, Course $course)
    {
        $request->user()->courses()->detach($course);

        return response()->json([
            'message' => 'Enrollment deleted successfully'
        ]);
    }

    public function gradeEnrollment(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'grade' => ["nullable", "numeric", "between:1,100"]
        ]);

        $enrollment->update($request->only(['grade']));

        return response()->json([
            'message' => 'Enrollment graded successfully'
        ]);
    }

    public function storeStudent(Course $course, User $student)
    {
        $this->authorize('checkOwnership', $course);

        if ($student->courses->contains($course))
        {
            return response()->json([
                'message' => 'Student already enrolled in this course'
            ]);
        }

        $student->courses()->attach($course);

        return response()->json([
            'message' => 'Student enrollment added successfully'
        ]);
    }

    public function destroyStudent(Course $course, User $student)
    {
        $this->authorize('checkOwnership', $course);

        $student->courses()->detach($course);

        return response()->json([
            'message' => 'Student enrollment deleted successfully'
        ]);
    }
}

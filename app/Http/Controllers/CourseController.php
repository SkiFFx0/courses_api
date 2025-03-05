<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function store(Request $request)
    {
        $courseData = $request->validate([
            'title' => ["required", "string", "max:255"],
            'description' => ["required", "string", "max:255"],
        ]);

        $courseData['teacher_id'] = auth()->id();

        Course::query()->create($courseData);

        return response()->json([
            'message' => 'Course created successfully'
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $courseData = $request->validate([
            'title' => ["nullable", "string", "max:255", Rule::unique('courses')->ignore($course->id)],
            'description' => ["nullable", "string", "max:255"],
        ]);

        $course->update($courseData);

        return response()->json([
            'message' => 'Course updated successfully'
        ]);
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'Course deleted successfully'
        ]);
    }
}

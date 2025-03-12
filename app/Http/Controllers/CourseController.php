<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\StoreRequest;
use App\Http\Requests\Course\UpdateRequest;
use App\Models\ApiResponse;
use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseController extends Controller
{
    use AuthorizesRequests;

    public function store(StoreRequest $request)
    {
        $courseData = $request->validated();

        $courseData['teacher_id'] = auth()->id();

        Course::query()->create($courseData);

        return ApiResponse::success('Course created successfully', [
            "course" => $courseData,
        ]);
    }

    public function update(UpdateRequest $request, Course $course)
    {
        $courseData = $request->validated();

        $this->authorize('checkOwnership', $course);

        $course->update($courseData);

        return ApiResponse::success('Course updated successfully', [
            'course' => $course
        ]);
    }

    public function destroy(Course $course)
    {
        $this->authorize('checkOwnership', $course);

        $course->delete();

        return ApiResponse::success('Course deleted successfully');
    }
}

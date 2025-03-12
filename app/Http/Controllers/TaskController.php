<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\ApiResponse;
use App\Models\Course;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function store(StoreRequest $request, Course $course)
    {
        $taskData = $request->validated();

        $taskData["course_id"] = $course->id;

        Task::query()->create($taskData);

        return ApiResponse::success('Task created successfully', [
            'course' => $course,
            'task' => $taskData,
        ]);
    }

    public function update(UpdateRequest $request, Task $task)
    {
        $this->authorize('checkOwnership', $task);

        $taskData = $request->validated();

        $task->update($taskData);

        return ApiResponse::success('Task updated successfully', [
            'task' => $task,
        ]);
    }

    public function destroy(Task $task)
    {
        $this->authorize('checkOwnership', $task);

        $task->delete();

        return ApiResponse::success('Task deleted successfully');
    }
}

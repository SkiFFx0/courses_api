<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Course $course)
    {
        $taskData = $request->validate([
            'title' => ["required", "string", "max:255", "unique:tasks,title"],
            'content' => ["required", "string", "max:255"],
        ]);

        $taskData["course_id"] = $course->id;

        Task::query()->create($taskData);

        return response()->json([
            'message' => 'Task created successfully'
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('checkOwnership', $task);

        $taskData = $request->validate([
            'title' => ["nullable", "string", "max:255", Rule::unique('tasks')->ignore($task->id)],
            'content' => ["nullable", "string", "max:255"],
        ]);

        $task->update($taskData);

        return response()->json([
            'message' => 'Task updated successfully'
        ]);
    }

    public function destroy(Task $task)
    {
        $this->authorize('checkOwnership', $task);

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }
}

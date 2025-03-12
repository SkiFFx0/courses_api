<?php

namespace App\Http\Controllers;

use App\Http\Requests\Submission\GradeSubmissionRequest;
use App\Http\Requests\Submission\StoreRequest;
use App\Models\ApiResponse;
use App\Models\Enrollment;
use App\Models\Submission;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    use AuthorizesRequests;

    public function store(StoreRequest $request, Task $task)
    {
        $request->validated();

        // Check if the authenticated user is enrolled in the course
        $this->authorize('submitSubmission', $task);

        // Create a new submission
        $user = auth()->user();
        $submission = new Submission();
        $submission->student_id = $user->id;
        $submission->task_id = $task->id;
        $submission->save();

        // Handle file uploads if present
        if ($request->hasFile('files'))
        {
            foreach ($request->file('files') as $file)
            {
                // Store the file in the 'submissions' directory under the 'public' disk
                $path = $file->store('submissions', 'public');

                // Get file metadata
                $originalName = $file->getClientOriginalName();
                $size = $file->getSize();
                $hash = hash_file('sha256', $file->path());

                // Create a record in the files table
                $submission->files()->create([
                    'name' => $originalName,
                    'hash' => $hash,
                    'size' => $size,
                    'path' => $path,
                ]);
            }
        }

        return ApiResponse::success('Submission created successfully', [
            'submission' => $submission->load('files'),
        ]);
    }

    public function destroy(Submission $submission)
    {
        $this->authorize('deleteSubmission', $submission);

        foreach ($submission->files as $file)
        {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }

        $submission->delete();

        return ApiResponse::success('Submission deleted successfully');
    }

    public function gradeSubmission(GradeSubmissionRequest $request, Submission $submission)
    {
        $request->validated();

        $submission->update($request->only(['grade']));

        return ApiResponse::success('Submission graded successfully', [
            'submission' => $submission,
        ]);
    }
}

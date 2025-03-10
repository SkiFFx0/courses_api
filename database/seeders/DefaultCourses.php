<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultCourses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::query()->create([
            'title' => 'PHP',
            'description' => 'PHP course',
            'teacher_id' => 2,
        ]);

        Task::query()->create([
            'title' => 'PHP Task 1',
            'content' => 'Task 1 content',
            'course_id' => 1,
        ]);

        Task::query()->create([
            'title' => 'PHP Task 2',
            'content' => 'Task 2 content',
            'course_id' => 1,
        ]);

        Course::query()->create([
            'title' => 'Laravel',
            'description' => 'Laravel course',
            'teacher_id' => 2,
        ]);

        Task::query()->create([
            'title' => 'Laravel Task 1',
            'content' => 'Task 1 content',
            'course_id' => 2,
        ]);

        Task::query()->create([
            'title' => 'Laravel Task 2',
            'content' => 'Task 2 content',
            'course_id' => 2,
        ]);
    }
}

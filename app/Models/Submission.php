<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use SoftDeletes;

    protected $table = 'submissions';

    protected $fillable = [
        'task_id',
        'student_id',
        'file_path',
        'grade',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}

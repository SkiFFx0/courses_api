<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $table = 'courses';

    protected $fillable = [
        'title',
        'description',
        'teacher_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'course_id', 'id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'course_id',
        'content',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'task_id', 'id');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}

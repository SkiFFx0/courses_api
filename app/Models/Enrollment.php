<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Pivot
{
    use SoftDeletes;

    protected $table = 'enrollments';

    protected $fillable = [
        'course_id',
        'student_id',
        'grade'
    ];
}

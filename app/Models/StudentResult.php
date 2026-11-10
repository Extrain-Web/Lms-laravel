<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'roll_no',
        'reg_no',
        'student_name',
        'photo',
        'father_name',
        'mother_name',
        'session',
        'course_code',
        'trade',
        'center',
        'institute_name',
        'exam_year',
        'issue_date',
        'gpa',
        'result_score',
        'grade',
        'marks',
        'verification_status',
        'qr_url',
    ];

    protected $casts = [
        'marks' => 'array',
        'gpa' => 'float',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['student_id', 'teacher_id', 'description'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'lesson_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('student_id', "!=", null)->where('teacher_id', "!=", null);
    }
}

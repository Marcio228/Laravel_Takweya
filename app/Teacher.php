<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['user_id', 'phone', 'dob', 'grade_id', 'subject', 'is_online'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'teacher_id', 'id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'teacher_id', 'id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id', 'id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id');
    }

    public function getSubjectsAttribute()
    {
        $subjects = $this->subjects()->pluck('name')->toArray();

        return implode(', ', $subjects);
    }
}

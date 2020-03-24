<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'slug'];

//    public function grade()
//    {
//        return $this->belongsTo(Grade::class, 'grade_id', 'id');
//    }

    public function grades()
    {
        return $this->belongsToMany(Subject::class, 'subject_grade', 'subject_id', 'grade_id');

    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher', 'subject_id', 'teacher_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name', 'slug'];

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'grade_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'grade_id', 'id');
    }

//    public function subjects()
//    {
//        return $this->hasMany(Subject::class, 'grade_id', 'id');
//    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_grade', 'grade_id', 'subject_id');
    }
}

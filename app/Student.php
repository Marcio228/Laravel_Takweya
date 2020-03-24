<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'phone', 'dob', 'grade_id', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'student_id', 'id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id', 'id');
    }
}

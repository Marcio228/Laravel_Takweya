<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = ['lesson_id', 'teacher_id'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}

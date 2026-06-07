<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'first_name', 'last_name', 'email', 'phone',
        'dob', 'gender', 'address', 'qualification', 'specialization',
        'photo', 'joining_date', 'status'
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
    ];

    // public function classes()
    // {
    //     return $this->belongsToMany(Classes::class, 'class_teacher');
    // }
      public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_teacher', 'teacher_id', 'class_id');
    }


    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
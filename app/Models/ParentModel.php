<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents';
    
    protected $fillable = [
        'father_name', 'father_phone', 'father_email', 'father_occupation',
        'mother_name', 'mother_phone', 'mother_email', 'mother_occupation',
        'address'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
}
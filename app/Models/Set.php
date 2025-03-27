<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'track_id',
        'room_id',
        'section_id',
        'department_id',
        'grade_id',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'set_student');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_set');
    }
}

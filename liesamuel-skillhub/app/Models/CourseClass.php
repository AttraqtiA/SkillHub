<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    use HasFactory;

    protected $table = 'courseclasses';
    protected $primaryKey = 'courseclass_id';

    protected $fillable = [
        'title',
        'description',
        'instructor_name',
        'start_date',
        'end_date',
        'duration',
        'level',
        'category',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    // One CourseClass has many enrollments
    public function enrollments()
    {
        return $this->hasMany(ParticipantClass::class, 'class_id', 'class_id');
    }

    // Many-to-Many: CourseClass <-> Participant through participant_classes
    public function participants()
    {
        return $this->belongsToMany(
            Participant::class,
            'participant_classes',
            'courseclass_id',        // FK
            'participant_id'   // FK
        )->withPivot([
            'participant_class_id',
            'enrolled_at',
            'status',
            'grade',
            'progress',
        ])->withTimestamps();
    }
}

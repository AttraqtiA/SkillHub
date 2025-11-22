<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'participants';
    protected $primaryKey = 'participant_id';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'birth_date',
        'gender',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // One Participant has many enrollments (participant_classes)
    public function enrollments()
    {
        return $this->hasMany(ParticipantClass::class, 'participant_id', 'participant_id');
    }

    // Many-to-Many: Participant <-> CourseClass through participant_classes
    public function classes()
    {
        return $this->belongsToMany(
            CourseClass::class,
            'participant_classes',
            'participant_id', // FK
            'courseclass_id'  // FK
        )->withPivot([
            'participant_class_id',
            'enrolled_at',
            'status',
            'grade',
            'progress',
        ])->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantClass extends Model
{
    use HasFactory;

    protected $table = 'participant_classes';
    protected $primaryKey = 'participant_class_id';

    protected $fillable = [
        'participant_id',
        'courseclass_id',
        'enrolled_at',
        'status',
        'grade',
        'progress',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'participant_id');
    }

    public function class()
    {
        return $this->belongsTo(CourseClass::class, 'courseclass_id', 'courseclass_id');
    }
}

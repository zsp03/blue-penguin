<?php

namespace App\Models;

use App\Enums\HakiStatus;
use App\Enums\HakiType;
use App\Enums\PublicationScale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Haki extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'faculty',
        'type',
        'status',
        'registration_no',
        'haki_no',
        'registered_at',
        'scale',
        'year',
        'link',
        'output',
        'haki_type',
    ];

    protected $casts = [
        'scale' => PublicationScale::class,
        'status' => HakiStatus::class,
        'haki_type' => HakiType::class
    ];

    public function lecturers(): BelongsToMany
    {
        return $this->belongsToMany(Lecturer::class);
    }

    public function faculties(): BelongsToMany
    {
        return $this->belongsToMany(Faculty::class);
    }
}

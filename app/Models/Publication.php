<?php

namespace App\Models;

use App\Enums\PublicationScale;
use App\Enums\PublicationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'authors',
        'link',
        'year',
        'type',
        'scale',
        'citation',
        'total_funds',
        'fund_source',
    ];

    protected $casts = [
        'authors' => 'array',
        'scale' => PublicationScale::class,
        'type' => PublicationType::class
    ];

    public function lecturers(): BelongsToMany
    {
       return $this->belongsToMany(Lecturer::class);
    }
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}

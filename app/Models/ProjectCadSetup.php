<?php

namespace App\Models;

use App\LocationSource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectCadSetup extends Model
{
    protected $fillable = [
        'project_id',
        'latitude',
        'longitude',
        'location_source',
        'geocoded_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'location_source' => LocationSource::class,
            'geocoded_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

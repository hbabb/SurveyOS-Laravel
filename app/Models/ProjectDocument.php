<?php

namespace App\Models;

use App\DocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectDocument extends Model
{
    protected $fillable = [
        'project_id',
        'type',
        'path',
        'original_filename',
        'mime_type',
        'size_bytes',
        'uploaded_by_employee_id',
    ];

    protected function casts(): array
    {
        return [
            'type' => DocumentType::class,
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function uploadedByEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'uploaded_by_employee_id');
    }

    public function parcelTransfers(): HasMany
    {
        return $this->hasMany(ParcelTransfer::class);
    }
}

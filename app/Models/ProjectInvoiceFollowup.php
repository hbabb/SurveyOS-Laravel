<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectInvoiceFollowup extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'employee_id',
        'note',
        'followed_up_at',
    ];

    protected function casts(): array
    {
        return [
            'followed_up_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}

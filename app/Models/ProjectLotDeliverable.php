<?php

namespace App\Models;

use App\LotDeliverableType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectLotDeliverable extends Model
{
    protected $fillable = [
        'project_lot_id',
        'type',
        'date_ordered',
        'date_completed',
    ];

    protected function casts(): array
    {
        return [
            'type' => LotDeliverableType::class,
            'date_ordered' => 'date',
            'date_completed' => 'date',
        ];
    }

    public function projectLot(): BelongsTo
    {
        return $this->belongsTo(ProjectLot::class);
    }
}

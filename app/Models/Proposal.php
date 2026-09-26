<?php

namespace App\Models;

use App\ProposalAcceptanceSource;
use App\ProposalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Proposal extends Model
{
    protected $fillable = [
        'proposal_no',
        'site_intake_id',
        'change_order_project_id',
        'service_type',
        'scope_description',
        'exclusions_description',
        'fee_amount',
        'status',
        'sent_at',
        'viewed_at',
        'accepted_at',
        'accepted_via',
        'accepted_by_employee_id',
        'accepted_note',
        'accepted_ip_address',
        'declined_at',
        'declined_reason',
    ];

    protected $attributes = [
        'status' => 'draft',
    ];

    protected function casts(): array
    {
        return [
            'fee_amount' => 'decimal:2',
            'status' => ProposalStatus::class,
            'sent_at' => 'datetime',
            'viewed_at' => 'datetime',
            'accepted_at' => 'datetime',
            'accepted_via' => ProposalAcceptanceSource::class,
            'declined_at' => 'datetime',
        ];
    }

    public function siteIntake(): BelongsTo
    {
        return $this->belongsTo(SiteIntake::class);
    }

    public function acceptedByEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'accepted_by_employee_id');
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class);
    }

    public function changeOrderProject(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'change_order_project_id');
    }
}

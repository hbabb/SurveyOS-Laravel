<?php

namespace App\Models;

use App\ProjectPriority;
use App\ProjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $fillable = [
        'project_no',
        'project_name',
        'proposal_id',
        'status',
        'status_changed_at',
        'priority',
        'field_scheduled_date',
        'invoiced_at',
        'last_followed_up_at',
        'customer_status',
        'target_delivery',
        'project_manager_id',
        'researcher_id',
        'is_active',
        'archived_at',
    ];

    protected $attributes = [
        'status' => 'research',
        'customer_status' => 'Project started',
        'is_active' => true,
    ];

    protected function casts(): array
    {
        return [
            'status' => ProjectStatus::class,
            'status_changed_at' => 'datetime',
            'priority' => ProjectPriority::class,
            'field_scheduled_date' => 'date',
            'invoiced_at' => 'datetime',
            'last_followed_up_at' => 'datetime',
            'target_delivery' => 'date',
            'is_active' => 'boolean',
            'archived_at' => 'datetime',
        ];
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function projectManager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'project_manager_id');
    }

    public function researcher(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'researcher_id');
    }

    public function fieldCrew(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'project_field_crew');
    }

    public function surveyDetails(): HasOne
    {
        return $this->hasOne(ProjectSurveyDetail::class);
    }

    public function parcels(): HasMany
    {
        return $this->hasMany(ProjectParcel::class);
    }

    public function femaReferences(): HasMany
    {
        return $this->hasMany(ProjectFemaReference::class);
    }

    public function invoiceFollowups(): HasMany
    {
        return $this->hasMany(ProjectInvoiceFollowup::class);
    }
}

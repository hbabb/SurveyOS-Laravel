<?php

namespace App\Models;

use App\EmployeePosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasApiTokens, HasRoles;

    protected string $guard_name = 'web';

    protected $fillable = [
        'user_id',
        'position',
        'initials',
        'is_active',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    protected function casts(): array
    {
        return [
            'position' => EmployeePosition::class,
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(EmployeeLicense::class);
    }

    public function acceptedProposals(): HasMany
    {
        return $this->hasMany(Proposal::class, 'accepted_by_employee_id');
    }

    public function managedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'project_manager_id');
    }

    public function researchedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'researcher_id');
    }

    public function fieldProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_field_crew');
    }

    public function certifyingSurveyDetails(): HasMany
    {
        return $this->hasMany(ProjectSurveyDetail::class, 'certifying_surveyor_id');
    }

    public function draftedSurveyDetails(): HasMany
    {
        return $this->hasMany(ProjectSurveyDetail::class, 'drafter_id');
    }

    public function checkedSurveyDetails(): HasMany
    {
        return $this->hasMany(ProjectSurveyDetail::class, 'checker_id');
    }

    public function projectInvoiceFollowups(): HasMany
    {
        return $this->hasMany(ProjectInvoiceFollowup::class);
    }

    public function uploadedDocuments(): HasMany
    {
        return $this->hasMany(ProjectDocument::class, 'uploaded_by_employee_id');
    }
}

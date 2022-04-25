<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    protected $table = 'project_status';

    protected $fillable = [
        'project_id',
        'development_status',
        'description',
        'mic_support',
        'fund_status',
        'fund_organisation',
        'fund_amount',
        'funding_date',
        'funding_support_needed',
        'project_delivery_status',
        'project_delivered_status',
        'project_implemented_by_ministry',
        'mic_support_deploy',
        'incubator_status',
        'name_of_incubator',
        'trl_level',
        'video_url',
        'ip_status',
        'ip_type',
        'is_patent_registered',
        'ip_number',
        'date_of_ip_reg',
        'number_of_ip_filed_till_date',
        'startup_status',
        'startup_name',
        'company_registration_status',
        'company_name',
        'company_registration_type',
        'company_registration_dpiit',
        'company_logo'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function is_permitted(User $user)
    {
        return in_array($user->id, $this->project->users()->pluck('users.id')->toArray(),false);
    }

    public function setFundingSupportNeededAttribute($value)
    {
        $this->attributes['funding_support_needed'] = $value ?? false;
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectType;
use App\ProductCategory;
use App\SubContractor;
use App\ProjectEnquiry;


class Project extends Model
{
    protected $table = "project";

    protected $fillable = [
        'project_name','project_type_id','project_date','commencement_date','completion_date','project_budget','developer','project_financier','surveyor_qty','commentery','mech_engg','architect','interior','main_contractor','project_category_id','sub_contractor_id','is_active'
    ];
    public function Projectenquiry()  
    {
        return $this->hasMany('App\ProjectEnquiry','project_id','id');
    }

    

}

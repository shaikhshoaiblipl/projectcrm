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
        'created_by','project_name','project_type_id','project_date','commencement_date','completion_date','project_budget','developer','project_financier','surveyor_qty','commentery','mech_engg','architect','interior','main_contractor','project_category_id','contractor_id','is_active','contractor'
    ];
    public function Projectenquiry(){
        return $this->hasMany('App\ProjectEnquiry','project_id','id');
    }
    public function getdeveloper(){         
        return $this->belongsTo('App\Client','developer','id');
    }
    public function getfinancier(){         
        return $this->belongsTo('App\Financier','project_financier','id');
    }
    public function getquantity(){         
        return $this->belongsTo('App\Quantity','surveyor_qty','id');
    }
    public function getmengineer(){         
        return $this->belongsTo('App\MechanicalEngineer','mech_engg','id');
    }
    public function getarchitect(){         
        return $this->belongsTo('App\Architect','architect','id');
    }
    public function getinterior(){         
        return $this->belongsTo('App\Interior','interior','id');
    }
    public function getmcontractor(){         
        return $this->belongsTo('App\Contractor','main_contractor','id');
    }
    public function getpcategory(){         
        return $this->belongsTo('App\ProductCategory','category_id','id');
    }
    public function getsubcontractor(){         
        return $this->belongsTo('App\SubContractor','contractor_id','id');
    }
    public function getprojecttype(){         
        return $this->belongsTo('App\ProjectType','project_type_id','id');
    }
    
    public function getProjectProductCategories(){
        return $this->hasMany(ProjectHasProductCategory::class,'project_id','id');
    }

    public function users(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    
}

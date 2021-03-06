<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_has_sub_contractor extends Model
{  
    protected $fillable = [
               'project_id',
               'contractor_id',
               'sub_contractor',
    ];

   public function getSubcontractor(){
     	return $this->hasOne(SubContractor::class,'id','contractor_id');
   }
    
}

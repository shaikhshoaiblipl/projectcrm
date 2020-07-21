<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectHasProductCategory extends Model
{  

    protected $fillable = [
        'project_id','product_category_id',
    ]; 

    public function category() 
    {
        return $this->belongsTo(ProductCategory::class,'product_category_id','id');
    } 

   
}

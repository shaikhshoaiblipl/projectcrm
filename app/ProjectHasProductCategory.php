<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectHasProductCategory extends Model
{  

    protected $fillable = [
        'project_id','product_category_id',
    ]; 

   
}

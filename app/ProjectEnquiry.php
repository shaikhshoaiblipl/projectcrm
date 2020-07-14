<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectEnquiry extends Model
{
    protected $table = "project_enquiry";

    protected $fillable = [
        'project_id','product_category_id','expected_date','enq_source'
    ];

    public function getproductcategory() 
    {
        return $this->belongsTO('App\ProductCategory','product_category_id','id');
    }

    public function getremarks() 
    {
        return $this->hasMany('App\EnquiryRemarks','enquiry_id','id');
    } 
}

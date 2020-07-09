<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryRemarks extends Model
{
    protected $fillable = [
        'enquiry_id','remarks','date'
    ]; 
}

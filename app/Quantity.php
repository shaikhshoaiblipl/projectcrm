<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{protected $fillable = [
        'project_id','name','is_active'
    ]; 

    protected $table= 'quantity';
}

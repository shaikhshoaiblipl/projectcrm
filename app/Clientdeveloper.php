<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientdeveloper extends Model
{
    
    protected $table= 'clientdeveloper';

    protected $fillable = [
        'project_id','name','is_active'
    ]; 

    

}

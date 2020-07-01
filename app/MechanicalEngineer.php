<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MechanicalEngineer extends Model
{
    protected $fillable = [
        'project_id','name','is_active'
    ]; 

    protected $table= 'mechanical_engg';
}

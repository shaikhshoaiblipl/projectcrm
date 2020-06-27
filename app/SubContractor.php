<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubContractor extends Model
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','is_active'
    ];
}

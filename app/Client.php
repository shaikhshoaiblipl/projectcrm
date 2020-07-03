<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table= 'client';

    protected $fillable = [
       'name','is_active'
    ]; 
}

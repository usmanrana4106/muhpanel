<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//*****Created By Usman Abbas*******//
class Verion extends Model
{
       protected $table = 'app_info';
    public $timestamps = false;
    protected $fillable = [
                          	  'id', 'version_code'
                          ];
}

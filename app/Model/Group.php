<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    public $timestamps = false;
 	protected $fillable = [
                            'id', 'parent_id', 'name', 'code', 'affects_gross'
                          ];
}

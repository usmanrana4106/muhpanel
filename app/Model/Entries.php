<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
    protected $table = 'entries';
    public $timestamps = false;
 	protected $fillable = [
                            'id', 'tag_id', 'entrytype_id', 'number', 'date', 'dr_total', 'cr_total', 'narration'
                          ];
}

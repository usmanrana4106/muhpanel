<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EntryType extends Model
{
    protected $table = 'entrytypes';
    public $timestamps = false;
 	protected $fillable = [
                            'id', 'label', 'name', 'description', 'base_type', 'numbering', 'prefix', 'suffix', 'zero_padding', 'restriction_bankcash'
                          ];
}

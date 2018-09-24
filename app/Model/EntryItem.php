<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EntryItem extends Model
{
    protected $table = 'entryitems';
    public $timestamps = false;
 	protected $fillable = [
                            'id', 'entry_id', 'ledger_id', 'amount', 'dc', 'reconciliation_date'
                          ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZipSettlements extends Model
{
    protected $table = 'zipsettlements';

    public function federalentity()
    {
        return $this->belongsTo('App\FederalEntities');
    }
}

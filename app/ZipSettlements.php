<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\SettlementsTypes;


class ZipSettlements extends Model
{
    protected $table = 'zipsettlements';

    public function federalentity()
    {
        return $this->belongsTo('App\FederalEntities');
    }

    public function settlement_type(){
        return $this->belongsTo(SettlementsTypes::class, 'id_settlement_type' )->select(['id', 'name']);
    }
}

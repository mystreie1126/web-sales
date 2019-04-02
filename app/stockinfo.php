<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stockinfo extends Model
{
    protected $table = 'sm_stockNeedToCount';

    public function stockShop(){
      return $this->hasMany('App\stockUpdate','needToCount_id');
    }
}

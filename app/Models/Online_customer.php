<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Online_customer extends Model
{
    protected $table = 'ps_customer';
    protected $primaryKey = 'id_customer';

    public function reward(){
    	return $this->hasMany('App\Models\Online_reward','id_customer');
    }
}

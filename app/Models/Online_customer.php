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

    public function voucher(){
        return $this->hasMany('App\Models\Online_voucher','id_customer');
    }

    public function order(){
    	return $this->hasMany('App\Order','id_customer');
    }

    public function order_detail(){
    	return $this->hasMany('App\Order_detail','id_customer');
    }
}

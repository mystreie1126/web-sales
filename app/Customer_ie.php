<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_ie extends Model
{
    protected $table = 'ps_customer';
    protected $primaryKey = 'id_customer';
    public function order(){
    	return $this->hasMany('App\Order','id_customer');
    }

}

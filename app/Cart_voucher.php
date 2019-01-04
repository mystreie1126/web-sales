<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart_voucher extends Model
{
    protected $table = 'ps_cart_rule';
    protected $primaryKey = 'id_cart_rule';
    public $timestamps = false;
}

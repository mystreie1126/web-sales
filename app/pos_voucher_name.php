<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_voucher_name extends Model
{
     protected $connection = 'mysql2';
     protected $table = 'ps_cart_rule_lang';

     public $timestamps = false;
}

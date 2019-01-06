<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class POS_voucher_name extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'ps_cart_rule_lang';

  public $timestamps = false;
}

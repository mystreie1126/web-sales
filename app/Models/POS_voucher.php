<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class POS_voucher extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'ps_cart_rule';
  protected $primaryKey = 'id_cart_rule';

  public $timestamps = false;
}

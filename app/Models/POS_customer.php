<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class POS_customer extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'ps_customer';
  protected $primaryKey = 'id_customer';

  public $timestamps = false;
}

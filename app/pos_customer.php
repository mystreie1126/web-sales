<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_customer extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'ps_customer';
    protected $primaryKey = 'id_customer';

    public $timestamps = false;
}

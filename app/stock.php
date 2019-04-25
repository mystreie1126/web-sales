<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'sm_updateStockRecord';
    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch_stockTake_history extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'sm_branchStockTake_history';
}

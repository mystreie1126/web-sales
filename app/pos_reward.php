<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pos_reward extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'ps_rewards';
    protected $primaryKey = 'id_reward';

    public $timestamps = false;
}

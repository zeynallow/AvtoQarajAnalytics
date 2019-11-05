<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $connection = 'mysql_primary';
    protected $table = 'car_type';
    protected $primaryKey = 'id_car_type';

}

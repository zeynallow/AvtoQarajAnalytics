<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $connection = 'mysql_primary';
    protected $table = 'car_model';
    protected $primaryKey = 'id_car_model';

}

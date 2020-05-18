<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarMake extends Model
{
  protected $connection = 'mysql_primary';
  protected $table = 'car_make';
  protected $primaryKey = 'id_car_make';


}

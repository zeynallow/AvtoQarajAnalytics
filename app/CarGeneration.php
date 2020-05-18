<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarGeneration extends Model
{
  protected $connection = 'mysql_primary';
  protected $table = 'car_generation';
  protected $primaryKey = 'id_car_generation';


}

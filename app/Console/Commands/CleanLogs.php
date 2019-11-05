<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class CleanLogs extends Command
{
  /**
  * The name and signature of the console command.
  *
  * @var string
  */
  protected $signature = 'CleanLogs:start';

  /**
  * The console command description.
  *
  * @var string
  */
  protected $description = 'Start Clean Database Logs for Unique Tracking';

  /**
  * Create a new command instance.
  *
  * @return void
  */
  public function __construct()
  {
    parent::__construct();
  }


  /**
  * Execute the console command.
  *
  * @return mixed
  */
  public function handle()
  {

    $car_search_track_logs = DB::table('car_search_track_logs')->delete();
    $category_track_logs = DB::table('category_track_logs')->delete();
    $product_track_logs = DB::table('product_track_logs')->delete();
    $route_track_logs = DB::table('route_track_logs')->delete();
    $shop_category_track_logs = DB::table('shop_category_track_logs')->delete();
    $shop_track_logs = DB::table('shop_track_logs')->delete();

    if($car_search_track_logs){
      echo "==> car_search_track_logs cleaned\n\r";
    }

    if($category_track_logs){
      echo "==> category_track_logs cleaned\n\r";
    }

    if($product_track_logs){
      echo "==> product_track_logs cleaned\n\r";
    }

    if($route_track_logs){
      echo "==> route_track_logs cleaned\n\r";
    }

    if($shop_category_track_logs){
      echo "==> shop_category_track_logs cleaned\n\r";
    }

    if($shop_track_logs){
      echo "==> shop_track_logs cleaned\n\r";
    }

    echo "====> successful \n\r";

  }

}

<?php

use Illuminate\Database\Seeder;

class SocialReportCancel extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    if(DB::table('social_report_cancels')->get()->count() == 0){

      DB::table('social_report_cancels')->insert([

        [
          'id' => '1',
          'description'=>'Müştəri ilə əlaqə saxlamaq mümkün olmadı',
          'color'=>'warning',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ]

      ]);

    } else { echo "\e[31mTable is not empty, therefore NOT "; }
  }
}

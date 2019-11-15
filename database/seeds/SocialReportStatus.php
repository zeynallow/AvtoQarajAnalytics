<?php

use Illuminate\Database\Seeder;


class SocialReportStatus extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {


    if(DB::table('social_report_statuses')->get()->count() == 0){

      DB::table('social_report_statuses')->insert([

        [
          'id' => '8',
          'name'=>'Müştəridən cavab gözlənir',
          'color'=>'info',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
          'id' => '1',
          'name'=>'Cavab gözləyir',
          'color'=>'warning',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
          'id' => '2',
          'name'=>'Mağaza İmtina',
          'color'=>'danger',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
          'id' => '3',
          'name'=>'Mağaza cavablayıb',
          'color'=>'success',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
          'id' => '4',
          'name'=>'Avtoqaraj cavablayıb',
          'color'=>'success',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
          'id' => '5',
          'name'=>'Avtoqaraj İmtina',
          'color'=>'danger',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
          'id' => '6',
          'name'=>'Staff Soft Delete',
          'color'=>'danger',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
          'id' => '7',
          'name'=>'Partner Soft Delete',
          'color'=>'danger',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
        ]

      ]);

    } else { echo "\e[31mTable is not empty, therefore NOT "; }


  }
}

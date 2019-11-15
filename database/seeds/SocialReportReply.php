<?php

use Illuminate\Database\Seeder;

class SocialReportReply extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if(DB::table('social_report_replies')->get()->count() == 0){

        DB::table('social_report_replies')->insert([

          [
            'id' => '1',
            'description'=>'Müştəri məlumatlandırıldı',
            'color'=>'success',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          ],
          [
            'id' => '2',
            'description'=>'Müştəri imtina etdi',
            'color'=>'danger',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          ]

        ]);

      } else { echo "\e[31mTable is not empty, therefore NOT "; }
    }
}

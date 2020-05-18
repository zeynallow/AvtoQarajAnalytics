<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SocialReportExport implements FromCollection, WithHeadings
{
  use Exportable;

  public function __construct($result)
  {
    $this->result = $result;
  }

  public function collection()
  {
    $results = $this->result;
    $data = [];

    foreach ($results as $key => $report) {
      if($report->network_type == 1){
        $network_type = 'Facebook';
      }elseif($report->network_type == 2){
        $network_type = 'Instagram';
      }elseif($report->network_type == 3){
        $network_type = 'Whatsapp';
      }else{
        $network_type=NULL;
      }


      $data[] = [
        'network_type' => $network_type,
        'shop_name' => \App\Shop::getShopName($report->shop_id),
        'client_pending' => $report->client_pending,
        'pending' => $report->pending,
        'garage_replied' => $report->garage_replied,
        'shop_replied' => $report->shop_replied,
        'garage_cancelled' => $report->garage_cancelled,
        'shop_cancel' => $report->shop_cancel,
        'total' => $report->client_pending+$report->pending+$report->garage_replied+$report->shop_replied+$report->garage_cancelled+$report->shop_cancel
      ];
      

    }

    return collect($data);
  }

  public function headings(): array
  {
    return [
      'Sosial şəbəkə',
      'Mağaza',
      'Müştəridən cavab göz.',
      'Cavab gözləyir',
      'Avtoqaraj cavablayıb',
      'Mağaza cavablayıb',
      'Avtoqaraj imtina',
      'Mağaza imtina',
      'Cəmi'
    ];


  }

}

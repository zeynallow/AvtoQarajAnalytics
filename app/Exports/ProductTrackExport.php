<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductTrackExport implements FromCollection, WithHeadings
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

    foreach ($results as $key => $result) {
      $data[] = [
        'product_id' => '#'.$result['product_id'].'',
        'product_name' => $result['product']['product_name'],
        'shop_name' => $result['shop']['name'],
        'click_count' => $result['sum_click_count'],
        'click_count_unique' => $result['sum_click_count_unique']
      ];
    }

    return collect($data);
  }

  public function headings(): array
  {
    return [
      'Məhsulun nömrəsi',
      'Məhsulun adı',
      'Mağaza',
      'Baxış sayı',
      'Baxış sayı (Unikal)'
    ];
  }

}

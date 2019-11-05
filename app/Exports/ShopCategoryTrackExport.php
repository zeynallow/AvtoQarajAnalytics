<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShopCategoryTrackExport implements FromCollection, WithHeadings
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
        'category_id' => '#'.$result['category_id'].'',
        'shop_name' => '#'.$result['shop']['name'].'',
        'category_name' => $result['category']['category_name'],
        'click_count' => $result['sum_click_count'],
        'click_count_unique' => $result['sum_click_count_unique']
      ];
    }

    return collect($data);
  }

  public function headings(): array
  {
    return [
      'Kateqoriya İD',
      'Mağaza adı',
      'Kateqoriyanın adı',
      'Baxış sayı',
      'Baxış sayı (Unikal)'
    ];
  }

}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CarSearchTrackExport implements FromCollection, WithHeadings
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
        'car_type' => $result['car_type']['name'],
        'car_make' => $result['car_make']['name'],
        'car_model' => $result['car_model']['name'],
        'car_generation' => $result['car_generation']['name'],
        'click_count' => $result['sum_click_count'],
        'click_count_unique' => $result['sum_click_count_unique']
      ];
    }

    return collect($data);
  }


  public function headings(): array
  {
    return [
      'Nəqliyyatın növü',
      'Marka',
      'Model',
      'Buraxılış ili',
      'Baxış sayı',
      'Baxış sayı (Unikal)'
    ];
  }

}

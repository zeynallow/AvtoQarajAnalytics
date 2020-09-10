<?php

namespace App\Http\Resources;

use App\SocialReport;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopReportResourceCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $network = ($this->network_type == SocialReport::NETWORK_TYPE_FACEBOOK ? 'facebook' :
            ($this->network_type == SocialReport::NETWORK_TYPE_INSTAGRAM ? 'instagram' : 'whatsapp'));

        return [
            'id' => $this->id,
            'createdDate' => $this->created_at,
            'productName' => $this->product_name,
            'network' => $network,
            'statusId' => $this->get_report_status->id,
            'statusName' => $this->get_report_status->name,
            'statusColor' => $this->get_report_status->color,
        ];
    }
}

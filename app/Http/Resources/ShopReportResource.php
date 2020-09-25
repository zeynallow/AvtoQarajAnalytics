<?php

namespace App\Http\Resources;

use App\SocialReport;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $network = ($this->network_type == SocialReport::NETWORK_TYPE_FACEBOOK ? 'facebook' :
            ($this->network_type == SocialReport::NETWORK_TYPE_INSTAGRAM ? 'instagram' : 'whatsapp'));

        $socialUrl = ($this->network_type == SocialReport::NETWORK_TYPE_FACEBOOK ? SocialReport::FACEBOOK_URL.'/'.$this->username :
                     ($this->network_type == SocialReport::NETWORK_TYPE_INSTAGRAM ? SocialReport::INSTAGRAM_URL.'/'.ltrim($this->username,'@') : SocialReport::WHATSAPP_URL.'/'.$this->username));
        return [
            'id' => $this->id,
            'clientName' => $this->client_name,
            'clientPhone' => $this->client_contact,
            'comment' => $this->client_comment,
            'carName' => $this->client_auto_car,
            'carReleaseYear' => $this->client_auto_year,
            'carVin' => $this->client_auto_vin,
            'createdDate' => $this->created_at,
            'updatedDate' => $this->updated_at,
            'productName' => $this->product_name,
            'network' => $network,
            'socialUrl' => $socialUrl,
            'statusId' => $this->get_report_status->id,
            'statusName' => $this->get_report_status->name,
            'statusColor' => $this->get_report_status->color,
        ];
    }
}

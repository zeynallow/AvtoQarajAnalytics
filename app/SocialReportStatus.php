<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialReportStatus extends Model
{
    public function socialReport(){
        return $this->hasMany(SocialReport::class, 'report_status');
    }
}

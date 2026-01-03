<?php

namespace DagaSmart\Surveillance\Models;


use DagaSmart\Organization\Models\Enterprise;
use DagaSmart\Organization\Models\EnterpriseFacilityDevice;
use DagaSmart\Organization\Models\Facility;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 设备推拉流模型
 */
class EnterPriseFacilityDeviceStream extends Model
{
    protected $table = 'biz_enterprise_facility_device_stream';


    /**
     * 机构
     * @return HasOne
     */
    public function enterprise(): hasOne
    {
        return $this->hasOne(Enterprise::class, 'id', 'enterprise_id')->select(['id', 'enterprise_name']);
    }

    /**
     * 设施
     * @return HasOne
     */
    public function facility(): hasOne
    {
        return $this->hasOne(Facility::class, 'id', 'facility_id')->select(['id', 'parent_id', 'facility_name']);
    }


}

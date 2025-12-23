<?php

namespace DagaSmart\Surveillance\Models;


use DagaSmart\Organization\Models\EnterpriseFacilityDevice;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 监控设备模型
 */
class SurveillanceDevice extends Model
{

    protected $table = 'biz_device';
    protected $primaryKey = 'id';

    public $timestamps = true;

    public function rel(): hasOne
    {
        return $this->hasOne(EnterPriseFacilityDevice::class,'device_id','id')->with(['enterprise','facility']);
    }

    public function enterprise(): HasOne
    {
        return $this->hasOne(EnterPriseFacilityDevice::class,
            'device_id',
            'id'
        )->with(['enterprise']);
    }

}

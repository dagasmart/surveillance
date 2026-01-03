<?php

namespace DagaSmart\Surveillance\Models;


use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 监控模型
 */
class SurveillanceStream extends Model
{
    protected $table = 'biz_stream';

    public function rel(): hasOne
    {
        return $this->hasOne(EnterPriseFacilityDeviceStream::class,'stream_id','id')->with(['enterprise','facility']);
    }

}

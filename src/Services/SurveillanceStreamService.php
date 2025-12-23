<?php

namespace DagaSmart\Surveillance\Services;

use DagaSmart\Surveillance\Models\SurveillanceStream;

/**
 * 转码直播表
 *
 * @method SurveillanceStream getModel()
 * @method SurveillanceStream|\Illuminate\Database\Query\Builder query()
 */
class SurveillanceStreamService extends AdminService
{
    protected string $modelName = SurveillanceStream::class;
}

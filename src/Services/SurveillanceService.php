<?php

namespace DagaSmart\Surveillance\Services;

use DagaSmart\Surveillance\Models\Surveillance;

/**
 * 转码直播表
 *
 * @method Surveillance getModel()
 * @method Surveillance|\Illuminate\Database\Query\Builder query()
 */
class SurveillanceService extends AdminService
{
    protected string $modelName = Surveillance::class;
}

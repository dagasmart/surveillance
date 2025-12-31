<?php

namespace DagaSmart\Surveillance\Services;

use DagaSmart\Organization\Services\EnterpriseService;
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


    /**
     * 机构单位列表
     */
    public function getEnterpriseAll(): array
    {
        return (new EnterpriseService)->query()
            ->select(['id as value', 'enterprise_name as label', 'id'])
            ->get()
            ->toArray();
    }

    /**
     * 递归选择项
     * @return array
     */
    public function options(): array
    {
        $id = request()->id;
        $enterprise_id = request()->enterprise_id;
        $data = $this->query()->from('biz_facility as a')
            ->join('biz_enterprise_facility as b','a.id','=','b.facility_id')
            ->select(['a.id as value', 'a.facility_name as label', 'a.id', 'a.parent_id'])
            ->when($enterprise_id, function($query) use ($enterprise_id) {
                $query->where('b.enterprise_id', $enterprise_id);
            })
            ->when($id, function($query) use ($id) {
                $query->where('b.facility_id', '<>', $id);
            })
            ->get()
            ->toArray();
        return array2tree($data);
    }


}

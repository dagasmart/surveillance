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
class SurveillanceDashboardService extends AdminService
{
    protected string $modelName = SurveillanceStream::class;

    public function loadRelations($query): void
    {
        $query->whereHas('rel', function ($query) {
            $mer_id = admin_mer_id();
            $query->where('module', admin_current_module())
                ->when($mer_id, function ($query) use ($mer_id) {
                    $query->where('mer_id', $mer_id);
                });
        })->with(['rel']);
    }

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
    public function facilityOptions(): array
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

    /**
     * 递归选择项
     * @return array
     */
    public function deviceOptions(): array
    {
        $id = request()->id;
        $facility_id = request()->facility_id;
        return $this->query()->from('biz_device as a')
            ->join('biz_enterprise_facility_device as b','a.id','=','b.device_id')
            ->select(['a.id as value', 'a.device_name as label'])
            ->when($facility_id, function($query) use ($facility_id) {
                $query->where('b.facility_id', $facility_id);
            })
            ->when($id, function($query) use ($id) {
                $query->where('b.device_id', '<>', $id);
            })
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

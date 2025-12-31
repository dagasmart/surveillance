<?php

namespace DagaSmart\Surveillance\Http\Controllers;

use DagaSmart\BizAdmin\Renderers\Form;
use DagaSmart\BizAdmin\Renderers\Page;
use DagaSmart\Surveillance\Services\SurveillanceStreamService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;

class SurveillanceStreamController extends AdminController
{
    protected string $serviceName = SurveillanceStreamService::class;

    public function list(): Page
    {
        $crud = $this->baseCRUD()
            ->filterTogglable(false)
            ->headerToolbar([
                $this->createButton('drawer', 300),
                ...$this->baseHeaderToolBar()
            ])
            ->autoGenerateFilter()
            ->affixHeader()
            ->columnsTogglable()
            ->footable(['expand' => 'first'])
            ->autoFillHeight(true)
            ->columns([
                amis()->TableColumn('id', 'ID')->sortable()->set('fixed','left'),
                amis()->TableColumn('title', '名称')->width(200)->set('fixed','left'),
                amis()->TableColumn('agree', '协议（源）'),
                amis()->TableColumn('remote', '输入流（源）')->width(300),
                amis()->TableColumn('name', '输出流名称'),
                amis()->TableColumn('url', '输出流地址'),
                amis()->TableColumn('fix', '输出流格式'),
                amis()->TableColumn('sip', '分流内网IP'),
                amis()->TableColumn('port', '分流公网端口'),
                amis()->TableColumn('piont', '经纬度'),
                amis()->TableColumn('sort', '排序'),
                amis()->TableColumn('state', '状态')->set('type', 'switch')->set('onText','上线')->set('offText','下线'),
                amis()->TableColumn('hot', '热点')->set('type', 'switch')->set('onText','是')->set('offText','否'),
                amis()->TableColumn('top', '置顶')->set('type', 'switch')->set('onText','是')->set('offText','否'),
                amis()->TableColumn('online', '设备状态')->className('text-center')->set('type', 'status')->set('onText','在线')->set('offText','离线'),
                amis()->TableColumn('created_at', admin_trans('admin.created_at'))->type('datetime')->sortable(),
                amis()->TableColumn('updated_at', admin_trans('admin.updated_at'))->type('datetime')->sortable(),
                $this->rowActions('drawer',300)
                    ->set('align','center')
                    ->set('fixed','right')
                    ->set('width',150)
            ]);

        return $this->baseList($crud);
    }

    public function form($isEdit = false): Form
    {
        return $this->baseForm()->mode('normal')->body([
            amis()->SelectControl('enterprise_id', '机构单位')
                ->options($this->service->getEnterpriseAll())
                ->value('${rel.enterprise_id}')
                ->searchable()
                ->clearable()
                ->required(),
            amis()->TreeSelectControl('facility_id', '主体位置')
                ->source(admin_url('biz/enterprise/${enterprise_id||0}/facility/options'))
                ->options($this->service->options())
                ->value('${rel.facility.id}')
                ->disabledOn('${!enterprise_id}')
                ->onlyLeaf(false)
                ->searchable()
                ->clearable()
                ->required(),
            amis()->TreeSelectControl('device_id', '监控设备')
                ->source(admin_url('biz/enterprise/${enterprise_id||0}/facility/${facility_id||0}/device/surveillance/options'))
                ->options([])
                ->value('${rel.device.id}')
                ->disabledOn('${!facility_id}')
                ->onlyLeaf(false)
                ->searchable()
                ->clearable()
                ->required(),
            amis()->TextControl('remote', '输入流(源)地址'),
            amis()->GroupControl()->body([
                amis()->Video()
                    ->isLive()
                    ->videoType('video/x-flv')
                    ->src('http://cfss.cc/cdn/hy/11602075.flv')
                    ->static()
                    ->className('border-solid border-1 border-color-[var(--colors-brand-5)] rounded-xl shadow-lg overflow-hidden clear-none'),
            ])->visible(!!$isEdit),
            amis()->SelectControl('fix', '输出流格式')
                ->options([['label' => 'video/x-flv', 'value' => 'flv'], ['label' => 'application/x-mpegURL-hls(m3u8)', 'value' => 'm3u8']]),
            amis()->TextControl('sip', '分流内网IP'),
            amis()->NumberControl('port', '分流公网端口'),
            amis()->TextControl('piont', '设备位置经纬度'),
            amis()->NumberControl('sort', '排序[0-255]'),
            amis()->SwitchControl('state', '状态')->onText('上线')->offText('下线')->value(1),
            amis()->SwitchControl('hot', '热点')->onText('是')->offText('否'),
            amis()->SwitchControl('top', '置顶')->onText('是')->offText('否'),
            amis()->GroupControl('online', '设备状态')->body([
                amis()->Status()
                    ->source([
                        '0' => [
                            'label' => '离线维护',
                            'icon' => 'fail',
                            'color' => 'red'
                        ],
                        '1' => [
                            'label' => '在线运行',
                            'icon' => 'success',
                            'color' => 'var(--colors-brand-5)'
                        ]
                    ])->value(1)
            ]),
        ]);
    }

    public function detail(): Form
    {
        return $this->baseDetail()->columnCount(3)->body([
            amis()->TextControl('id', 'ID')->static(),
            amis()->TextControl('title', '名称')->static(),
            amis()->TextControl('agree', '协议（源）')->static(),
            amis()->TextControl('remote', '输入流（源）')->static(),
            amis()->TextControl('name', '输出流名称')->static(),
            amis()->TextControl('url', '输出流地址')->static(),
            amis()->TextControl('fix', '输出流格式')->static(),
            amis()->TextControl('sip', '分流内网IP')->static(),
            amis()->TextControl('port', '分流公网端口')->static(),
            amis()->TextControl('piont', '经纬度')->static(),
            amis()->TextControl('sort', '排序[0-255]')->static(),
            amis()->TextControl('state', '状态：0禁用，1启用')->static(),
            amis()->TextControl('hot', '热点：1是， 0否')->static(),
            amis()->TextControl('top', '置顶：1是，0否')->static(),
            amis()->TextControl('online', '1在线，0离线')->static(),
            amis()->TextControl('created_at', admin_trans('admin.created_at'))->static(),
            amis()->TextControl('updated_at', admin_trans('admin.updated_at'))->static(),
        ])->disabled();
    }

    public function screen(): Page
    {
        return $this->basePage()->body([
            amis()->Grid()->columns([
                amis()->Panel()->title('面板1')
                    ->className('Panel')
                    ->set('sm',8)
                    ->body([
                        amis()->Video()
                            ->isLive()
                            ->videoType('application/x-mpegURL')
                            ->src('https://cfss.cc/cdn/hy/11352898.flv'),
                        amis()->Video()->isLive()->src('https://cfss.cc/cdn/hy/11352898.flv')
                    ]),
                amis()->Panel()->title('二楼4路')
                    ->className('Panel')
                    ->set('sm',4)
                    ->body([
                        amis()->Video()->isLive()->src('http://cfss.cc/cdn/hy/11602075.flv'),
                        amis()->Divider(),
                        amis()->Video()->isLive()->src('http://cfss.cc/cdn/hy/29465863.flv'),
                        amis()->Divider(),
                        amis()->Video()->isLive()->src('http://cfss.cc/cdn/hy/11601957.flv'),
                    ]),
            ]),
        ]);
    }
}

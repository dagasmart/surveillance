<?php

namespace DagaSmart\Surveillance\Http\Controllers;

use DagaSmart\BizAdmin\Renderers\Form;
use DagaSmart\BizAdmin\Renderers\Page;
use DagaSmart\Surveillance\Services\SurveillanceService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;

class SurveillanceDeviceController extends AdminController
{
    protected string $serviceName = SurveillanceService::class;

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
                amis()->TableColumn('id', 'ID')->sortable(),
                amis()->TableColumn('title', '名称')->width(200),
                amis()->TableColumn('agree', '协议（源）'),
                amis()->TableColumn('remote', '输入流（源）')->width(300),
                amis()->TableColumn('name', '输出流名称'),
                amis()->TableColumn('url', '输出流地址'),
                amis()->TableColumn('fix', '输出流格式'),
                amis()->TableColumn('sip', '分流内网IP'),
                amis()->TableColumn('port', '分流公网端口'),
                amis()->TableColumn('piont', '经纬度'),
                amis()->TableColumn('sort', '排序'),
                amis()->TableColumn('state', '状态')->set('type', 'switch'),
                amis()->TableColumn('hot', '热点')->set('type', 'switch'),
                amis()->TableColumn('top', '置顶')->set('type', 'switch'),
                amis()->TableColumn('online', '在线')->set('type', 'switch'),
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

            amis()->TextControl('title', '名称'),
            amis()->TextControl('remote', '输入流（源）'),
            amis()->GroupControl()->body([
                amis()->Video()
                    ->isLive()
                    ->videoType('video/x-flv')
                    ->src('http://cfss.cc/cdn/hy/11602075.flv')
                    ->static()
                    ->className('border-solid border-1 border-color-[var(--colors-brand-5)] rounded-xl shadow-lg overflow-hidden clear-none'),
            ]),
            amis()->SelectControl('fix', '输出流格式')
                ->options([['label' => 'video/x-flv', 'value' => 'flv'], ['label' => 'application/x-mpegURL-hls', 'value' => 'm3u8']]),
            amis()->TextControl('sip', '分流内网IP'),
            amis()->NumberControl('port', '分流公网端口'),
            amis()->TextControl('piont', '经纬度'),
            amis()->NumberControl('sort', '排序[0-255]'),
            amis()->SwitchControl('state', '状态'),
            amis()->SwitchControl('hot', '热点'),
            amis()->SwitchControl('top', '置顶'),
            amis()->ButtonGroupControl('online', '设备状态')
                ->options([['label' => '在线', 'value' => '1'], ['label' => '离线', 'value' => '0']]),
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

//            amis()->TextControl('id', 'ID')->static(),
//            amis()->TextControl('title', '名称')->static(),
//            amis()->TextControl('agree', '协议（源）')->static(),
////			amis()->TextControl('uuid', '账号')->static(),
////			amis()->TextControl('pass', '密码')->static(),
////			amis()->TextControl('ip', 'IP')->static(),
////			amis()->TextControl('iport', '端口')->static(),
////			amis()->TextControl('path', '路径')->static(),
////			amis()->TextControl('channel', '通道')->static(),
////			amis()->TextControl('subtype', '子通道')->static(),
//            amis()->TextControl('remote', '推流完整路径（源）')->static(),
//            amis()->TextControl('name', '流名称')->static(),
//            amis()->TextControl('url', '播放地址')->static(),
////			amis()->TextControl('sip', '分流内网IP')->static(),
////			amis()->TextControl('port', '分流公网端口')->static(),
//            amis()->TextControl('piont', '经纬度')->static(),
//            amis()->SwitchControl('status', '状态'),
//            amis()->SwitchControl('hot', '热点'),
//            amis()->SwitchControl('top', '置顶'),
//            amis()->SwitchControl('type', '类别'),
//            amis()->SwitchControl('stat', '在线'),
//            amis()->TextControl('created_at', __('admin.created_at'))->static(),
//            amis()->TextControl('updated_at', __('admin.updated_at'))->static()
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

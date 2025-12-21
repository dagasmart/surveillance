<?php
declare(strict_types=1);
namespace DagaSmart\Surveillance;

use Exception;
use DagaSmart\BizAdmin\Renderers\Form;
use DagaSmart\BizAdmin\Renderers\TextControl;
use DagaSmart\BizAdmin\Extend\ServiceProvider;


class SurveillanceServiceProvider extends ServiceProvider
{
	protected $menu = [
        [
            'parent' => NULL,
            'title' => '智能监控',
            'url' => '/biz/surveillance',
            'url_type' => 1,
            'icon' => 'icon-park-outline:surveillance-cameras-one',
        ],
        [
            'parent' => '智能监控',
            'title' => '监控管理',
            'url' => '/biz/surveillance/index',
            'url_type' => 1,
            'icon' => 'icon-park-outline:surveillance-cameras-two',
        ],
        [
            'parent' => '智能监控',
            'title' => '监控展板',
            'url' => '/biz/surveillance/screen',
            'url_type' => 1,
            'icon' => 'simple-line-icons:camrecorder',
        ]

    ];

    /**
     * @return void
     * @throws Exception
     */
    public function register(): void
    {
        parent::register();

        /**加载路由**/
        parent::registerRoutes(__DIR__.'/Http/routes.php');
        /**加载语言包**/
        if ($lang = parent::getLangPath()) {
            $this->loadTranslationsFrom($lang, $this->getCode());
        }

    }

	public function settingForm(): ?Form
	{
	    return $this->baseSettingForm()->body([
            TextControl::make()->name('value')->label('Value')->required(),
	    ]);
	}
}

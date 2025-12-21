<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $connection = 'biz';

    private string $table = 'nms_surveillance';

    /**
     * 执行迁移
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->table)) {
            //创建表
            Schema::create($this->table, function (Blueprint $table) {
            $table->comment('直播监控转码表');
            $table->increments('id');
            $table->string('title')->nullable()->comment('名称');
            $table->string('agree')->nullable()->comment('协议（源）');
            $table->string('remote')->nullable()->comment('输入流（源）');
            $table->string('name')->nullable()->comment('输出流名称');
            $table->string('url')->nullable()->comment('输出流地址');
            $table->string('fix')->nullable()->comment('输出流格式');
            $table->string('sip')->default('127.0.0.1')->nullable()->comment('分流内网IP');
            $table->smallInteger('port')->default(8000)->nullable()->comment('分流公网端口');
            $table->string('piont')->nullable()->comment('经纬度');
            $table->smallInteger('sort')->default(10)->nullable()->comment('排序[0-255]');
            $table->smallInteger('state')->default(0)->nullable()->comment('状态：0禁用，1启用');
            $table->smallInteger('hot')->default(0)->nullable()->comment('热点：1是， 0否');
            $table->smallInteger('top')->default(0)->nullable()->comment('置顶：1是，0否');
            $table->smallInteger('online')->default(0)->nullable()->comment('1在线，0离线');
            $table->timestamps();
            $table->softDeletes();
            });
        }
    }

    /**
     * 迁移回滚
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasTable($this->table)) {
            //检查是否存在数据
            $exists = DB::table($this->table)->exists();
            //不存在数据时，删除表
            if (!$exists) {
                //删除 reverse
                Schema::dropIfExists($this->table);
            }
        }
    }
};

<?php

namespace App\Admin\Metrics\Plugin;

use App\Models\PluginAccount;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\RadialBar;
use Illuminate\Http\Request;

class Scripts extends RadialBar
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $this->title('外挂脚本');
        $this->height(400);
        $this->chartHeight(300);
        $this->chartLabels('开挂中');
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $query = PluginAccount::groupBy('script_state');
        if ($filter_user_id = isWangbo()) {
            $query = $query->where('user_id', '<>', $filter_user_id);
        }
        if (isAgent()) {
            $query = $query->where('user_id', Admin::user()['id']);
        }
        $script_count = $query->selectRaw('count(*) count,script_state')
            ->pluck('count', 'script_state')
            ->toArray();
        $total = array_sum($script_count);
        $opening = $script_count[2] ?? 0;
        // 卡片内容
        $this->withContent($total);
        // 卡片底部
        $this->withFooter($script_count[0] ?? 0, $script_count[1] ?? 0, $opening);
        // 图表数据
        $this->withChart($total === 0 ? 0 : bcdiv($opening, $total, 2) * 100);
    }

    /**
     * 设置图表数据.
     *
     * @param int $data
     *
     * @return $this
     */
    public function withChart(int $data)
    {
        return $this->chart([
            'series' => [$data],
        ]);
    }

    /**
     * 卡片内容
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex flex-column flex-wrap text-center">
    <h1 class="font-lg-2 mt-2 mb-0">{$content}</h1>
    <small>总数</small>
</div>
HTML
        );
    }

    /**
     * 卡片底部内容.
     *
     * @param string $new
     * @param string $open
     * @param string $response
     *
     * @return $this
     */
    public function withFooter($new, $open, $response)
    {
        return $this->footer(
            <<<HTML
<div class="d-flex justify-content-between p-1" style="padding-top: 0!important;">
    <div class="text-center">
        <p>未登录</p>
        <span class="font-lg-1" style="color: #586cb1">{$new}</span>
    </div>
    <div class="text-center">
        <p>登录未使用</p>
        <span class="font-lg-1" style="color: #dda451">{$open}</span>
    </div>
    <div class="text-center">
        <p>开挂中</p>
        <span class="font-lg-1" style="color: #21b978">{$response}</span>
    </div>
</div>
HTML
        );
    }
}


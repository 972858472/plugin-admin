<?php

namespace App\Admin\Metrics\Plugin;

use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;

class Logs extends Line
{
    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->dropdown([
            '7'   => '近7天',
            '30'  => '最近一月',
            '365' => '最近一年',
        ]);
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
        $title = $request->get('title');
        switch ($request->get('option')) {
            case '365':
                $this->getChartData(365, $title);
                break;
            case '30':
                $this->getChartData(30, $title);
                break;
            case '7':
            default:
                $this->getChartData(7, $title);
        }
    }

    protected function getChartData($day, $title)
    {
        $model = getLogModel($title);
        $query = $model->where('created_at', '>', Carbon::parse("-$day days")->toDateString());
        if ($filter_user_id = isWangbo()) {
            $query = $query->where('user_id', '<>', $filter_user_id);
        }
        if (isAgent()) {
            $query = $query->where('user_id', Admin::user()['id']);
        }
        $data = $query->selectRaw('DATE(created_at) as date,sum(diff) as diffs')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->pluck('diffs', 'date')->toArray();
        $ChartsData = $this->getDateArray($day, $data);
        $this->withContent('总收益：' . array_sum($ChartsData), $this->getColor($title));
        $this->withChart($title, array_keys($ChartsData), array_values($ChartsData));
    }

    /**
     * 设置图表数据
     * @param $title
     * @param array $x
     * @param array $y
     * @return Logs
     */
    public function withChart($title, array $x, array $y = [])
    {
        return $this->chart([
            'series'  => [
                [
                    'name' => $title,
                    'data' => $y
                ]
            ],
            'xaxis'   => [
                'categories' => $x,
                'title'      => '日期'
            ],
            'tooltip' => [
                'enabled' => true
            ],
            'colors'  => [$this->getColor($title)]
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content, $color)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-ms-1" style="color: $color">{$content}</h2>
    <span class="mb-0 mr-1 text-80">每日收益</span>
</div>
HTML
        );
    }

    public function parameters(): array
    {
        return [
            'title' => $this->title
        ];
    }

    /**
     * @param $day
     * @return array
     */
    protected function getDateArray($day, $data): array
    {
        $array = [];
        for ($i = $day; $i >= 0; $i--) {
            $date = Carbon::parse("-$i days")->toDateString();
            $array[$date] = $data[$date] ?? 0;
        }
        return $array;
    }

    protected function getColor($title)
    {
        $array = [
            '金子' => Admin::color()->yellow(),
            '木材' => Admin::color()->primary(),
            '肉'  => Admin::color()->danger()
        ];
        return $array[$title];
    }
}

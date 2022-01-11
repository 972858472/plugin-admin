<?php
/**
 * @Author zayn
 * @Date 2021/11/16 11:31
 */

namespace App\Admin\RenderTable;

use App\Admin\Repositories\PluginBullionLog;
use App\Admin\Repositories\PluginMeatLog;
use App\Admin\Repositories\PluginWoodLog;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class Logs extends LazyRenderable
{
    public function grid(): Grid
    {
        $model = getLogModel($this->model);
        $type = request()->get('app-admin-rendertable-logs__') ?? 1;
        return Grid::make($model, function (Grid $grid) use ($type) {
            $grid->column('date')->setLabel('日期')->width('30%');
            $grid->column('diffs')->setLabel('变化量')->display(function ($diffs) {
                if ($diffs > 0) {
                    $color = 'red';
                    $direction = 'icon-arrow-up';
                } elseif ($diffs < 0) {
                    $color = '#21b978';
                    $direction = 'icon-arrow-down';
                } else {
                    $color = '#b9c3cd';
                    $direction = '';
                }
                return "<span style='color: $color'>$diffs<i class='feather  $direction'></i></span>";
            });

            if ($type == 2) {
                $grid->model()
                    ->where('account_id', $this->account_id)
                    ->selectRaw('DATE(created_at) as date,sum(diff) as diffs')
                    ->groupByRaw('DATE(created_at)')
                    ->orderByDesc('date');
            } else {
                $grid->model()
                    ->where('account_id', $this->account_id)
                    ->selectRaw('created_at date,diff diffs,amount')
                    ->orderByDesc('date');
                $grid->column('amount')->setLabel('变化后余额');
            }

            $grid->fixColumns(0, 0);
            $grid->disableActions();
            $grid->disableColumnSelector();

            $grid->paginate(10);


            $grid->disableFilterButton();
            $grid->showFilter();
            $grid->filter(function (Grid\Filter $filter) use ($type) {
                $filter->panel();
                $filter->expand();
                $filter->equal(' ')->radio([1 => '每次变化详情', 2 => '日总变化量'])->default($type)->ignore()->width(4);
            });
        });
    }
}


<?php
/**
 * @Author zayn
 * @Date 2021/11/16 11:31
 */

namespace App\Admin\RenderTable;

use App\Admin\Repositories\PluginBullionLog;
use App\Admin\Repositories\PluginEquipment;
use App\Admin\Repositories\PluginMeatLog;
use App\Admin\Repositories\PluginWoodLog;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class Equipments extends LazyRenderable
{
    public function grid(): Grid
    {
        return Grid::make(new PluginEquipment(), function (Grid $grid) {
            $grid->model()->where('account_id', $this->account_id);

            $grid->column('name')->setLabel(trans('plugin-equipment.fields.name'));
            $grid->column('map_index')->setLabel('类型')->using(MAP_INDEX);
            $grid->column('durable')->setLabel(trans('plugin-equipment.fields.durable'));
            $grid->column('grade')->setLabel(trans('plugin-equipment.fields.grade'));
            $grid->column('content')->setLabel(trans('plugin-equipment.fields.content'))->toArray();
            $grid->column('created_at');

            $grid->fixColumns(0, 0);
            $grid->disableActions();
            $grid->disableColumnSelector();
            $grid->paginate(3);
        });
    }
}


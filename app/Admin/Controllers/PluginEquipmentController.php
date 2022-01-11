<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\PluginEquipment;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PluginEquipmentController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new PluginEquipment(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('account_id');
            $grid->column('name');
            $grid->column('level');
            $grid->column('content');
            $grid->column('created_at');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new PluginEquipment(), function (Show $show) {
            $show->field('id');
            $show->field('account_id');
            $show->field('name');
            $show->field('level');
            $show->field('content');
            $show->field('created_at');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new PluginEquipment(), function (Form $form) {
            $form->display('id');
            $form->text('account_id');
            $form->text('name');
            $form->text('level');
            $form->text('content');
            $form->text('created_at');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}

<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\PluginBullionLog;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PluginBullionLogController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new PluginBullionLog(), function (Grid $grid) {
            $grid->column('bullion_log_id')->sortable();
            $grid->column('account_id');
            $grid->column('amount');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('bullion_log_id');

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
        return Show::make($id, new PluginBullionLog(), function (Show $show) {
            $show->field('bullion_log_id');
            $show->field('account_id');
            $show->field('amount');
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
        return Form::make(new PluginBullionLog(), function (Form $form) {
            $form->display('bullion_log_id');
            $form->text('account_id');
            $form->text('amount');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}

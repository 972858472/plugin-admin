<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

// 覆盖默认配置
config(['admin' => user_admin_config()]);
config(['app.locale' => config('admin.lang') ?: config('app.locale')]);

Admin::style('.main-sidebar .nav-sidebar .nav-item>.nav-link {
    border-radius: .1rem;
}');

Admin::navbar(function (\Dcat\Admin\Layout\Navbar $navbar) {

    $method = config('admin.layout.horizontal_menu') ? 'left' : 'right';

    // ajax请求不执行
    if (!Dcat\Admin\Support\Helper::isAjaxRequest()) {
        $navbar->$method(App\Admin\Actions\AdminSetting::make()->render());
    }
});

Grid::resolving(function (Grid $grid) {
    //列选择显示
    $grid->showColumnSelector();
    //tool背景
    $grid->toolsWithOutline(false);
    //禁用批量操作
    $grid->disableBatchActions();
    $grid->disableRowSelector();
    //启用滚动条
    $grid->scrollbarX();
    //禁用显示
    $grid->disableViewButton();
    $grid->fixColumns(1);
});

Form::resolving(function (Form $form) {
    $form->disableViewButton();
    $form->footer(function ($footer) {
        // 去掉`查看`checkbox
        $footer->disableViewCheck();

        // 去掉`继续编辑`checkbox
        $footer->disableEditingCheck();

        // 去掉`继续创建`checkbox
        $footer->disableCreatingCheck();

    });
});

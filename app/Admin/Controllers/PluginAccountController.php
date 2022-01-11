<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Equipments;
use App\Admin\Actions\Logs;
use App\Admin\Repositories\PluginAccount;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Hash;

class PluginAccountController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        return Grid::make(new PluginAccount(), function (Grid $grid) {
            if ($filter_user_id = isWangbo()) $grid->model()->where('user_id', '<>', $filter_user_id);

            $grid->model()->with(['user'])->orderByDesc('account_id');
            //权限限制
            if (isAgent()) {
                $grid->disableEditButton();
                $grid->disableDeleteButton();
                $grid->disableCreateButton();
                $grid->model()->where('user_id', Admin::user()['id']);
            }

            $grid->column('account_id')->sortable();
            $grid->column('user.username')->setLabel('代理商')->filter();
            $grid->column('account');
            $grid->column('state')
                ->using(ACCOUNT_STATE)
                ->label(ACCOUNT_STATE_COLOR)
                ->filter(Grid\Column\Filter\In::make(ACCOUNT_STATE));
            $grid->column('script_state')
                ->using(SCRIPT_STATE)
                ->label(SCRIPT_STATE_COLOR)
                ->filter(Grid\Column\Filter\In::make(SCRIPT_STATE));
            $grid->column('game_state')
                ->using(GAME_STATE)
                ->label(GAME_STATE_COLOR)
                ->filter(Grid\Column\Filter\In::make(GAME_STATE));

            $grid->column('games')->display(function ($games) {
                if (!$games) return '';
                $games = json_decode($games, true);
                foreach ($games as &$game) {
                    $game = GAMES[$game] ?? '';
                }
                return $games;
            })->label();

            $grid->column('game_account')->setLabel('钱包地址');
            $grid->column('created_at')->sortable();
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('account');
                $filter->in('state')->multipleSelect(ACCOUNT_STATE);
                $filter->in('script_state')->multipleSelect(SCRIPT_STATE);
                $filter->in('game_state')->multipleSelect(GAME_STATE);
            });

            $grid->actions(function (Grid\Displayers\Actions $action) {
                $action->append(new Equipments());
                $action->append(new Logs('金子'));
                $action->append(new Logs('木材'));
                $action->append(new Logs('肉'));
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
    protected function detail($id): Show
    {
        return Show::make($id, new PluginAccount(), function (Show $show) {
            $show->field('account_id');
            $show->field('account');
            $show->field('password');
            $show->field('state');
            $show->field('script_state');
            $show->field('game_state');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(): Form
    {
        return Form::make(new PluginAccount(), function (Form $form) {

            if ($filter_user_id = isWangbo()) {
                $user_options = Administrator::where('id', '<>', $filter_user_id)->pluck('username', 'id');
            } else {
                $user_options = Administrator::pluck('username', 'id');
            }
            $form->select('user_id')->label('代理商')->options($user_options)->required();

            if ($form->isEditing()) {
                $form->text('game_account')->required()->disable()->label('钱包地址');
            } else {
                $form->text('game_account')->required()->label('钱包地址');
            }

            $form->text('account')->required();
            $form->password('password');
            $form->hidden('api_token');
            $form->radio('state')->options(ACCOUNT_STATE)->default(0);

            if ($form->isEditing()) {
                $form->radio('script_state')->options(SCRIPT_STATE);
                $form->radio('game_state')->options(GAME_STATE);
            }

            $form->checkbox('games')->options(GAMES)->saveAsJson();

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {

                    $form->password = Hash::make($form->password);
                }
                if (!$form->password) {
                    $form->deleteInput('password');
                }
                if ($form->isCreating()) {
                    if (\App\Models\PluginAccount::whereAccount($form->account)->first()) {
                        throw new \Exception("账号已存在");
                    }
                    $form->api_token = Hash::make($form->password);
                }
            });
        });
    }
}

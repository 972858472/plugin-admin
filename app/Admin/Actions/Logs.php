<?php
/**
 * @Author zayn
 * @Date 2021/11/16 11:44
 */

namespace App\Admin\Actions;

use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Widgets\Modal;

class Logs extends RowAction
{
    public function render()
    {
        switch ($this->title) {
            case'金子':
                $iconName = 'icon-award';
                break;
            case '木材' :
                $iconName = 'icon-sliders';
                break;
            case '肉' :
                $iconName = 'icon-gitlab';
                break;
            default:
                $iconName = 'icon-award';
        }
        return Modal::make()
            ->lg()
            ->title($this->title . '日志')
            ->body(\App\Admin\RenderTable\Logs::make()->payload([
                'model'      => $this->title,
                'account_id' => $this->row->account_id
            ]))
            ->button('<a href="javascript:void(0)"><i class="feather grid-action-icon ' . $iconName . '" title="' . $this->title . '"></i>&nbsp;&nbsp;</a>');
    }
}

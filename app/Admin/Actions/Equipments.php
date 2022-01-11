<?php
/**
 * @Author zayn
 * @Date 2021/11/16 11:44
 */

namespace App\Admin\Actions;

use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Widgets\Modal;

class Equipments extends RowAction
{
    public function render()
    {
        return Modal::make()
            ->lg()
            ->title('装备列表')
            ->body(\App\Admin\RenderTable\Equipments::make()->payload([
                'account_id' => $this->row->account_id
            ]))
            ->button('<a href="javascript:void(0)"><i class="feather grid-action-icon icon-command" title="装备列表"></i>&nbsp;&nbsp;</a>');
    }
}

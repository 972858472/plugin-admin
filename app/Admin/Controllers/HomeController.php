<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Admin\Metrics\Plugin\Logs;
use App\Admin\Metrics\Plugin\Scripts;
use App\Admin\Metrics\Plugin\WoodLog;
use App\Http\Controllers\Controller;
use Dcat\Admin\Admin;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('主页')
            ->description('概览')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row(new Scripts());
                });

                $row->column(6, function (Column $column) {
                    $column->row((new Logs('金子')));
                    $column->row((new Logs('木材')));
                    $column->row((new Logs('肉')));
                });
            });
    }
}

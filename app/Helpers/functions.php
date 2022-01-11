<?php

use App\Models\PluginBullionLog;
use App\Models\PluginMeatLog;
use App\Models\PluginWoodLog;
use Dcat\Admin\Admin;
use Dcat\Admin\Models\Administrator;
use Illuminate\Support\Arr;

if (!function_exists('user_admin_config')) {
    function user_admin_config($key = null, $value = null)
    {
        $session = session();

        if (!$config = $session->get('admin.config')) {
            $config = config('admin');

            $config['lang'] = config('app.locale');
        }

        if (is_array($key)) {
            // 保存
            foreach ($key as $k => $v) {
                Arr::set($config, $k, $v);
            }

            $session->put('admin.config', $config);

            return true;
        }

        if ($key === null) {
            return $config;
        }

        return Arr::get($config, $key, $value);
    }
}

if (!function_exists('success')) {
    /**
     * 接口成功返回
     * @param mixed $data
     * @param string $msg
     * @return array
     * @author zayn
     * @date 2020-12-10
     *
     */
    function success($data = [], string $msg = "success"): array
    {
        return ['code' => 0, 'msg' => $msg, 'data' => $data];
    }
}

if (!function_exists('fail')) {
    /**
     * 接口错误返回
     * @param mixed $data
     * @param string $msg
     * @param int $code
     * @return array
     * @author zayn
     * @date 2020-12-10
     *
     */
    function fail($data = [], string $msg = "fail", int $code = 1): array
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }
}

if (!function_exists('getLogModel')) {
    /**
     * 获取日志model
     */
    function getLogModel($logModelName)
    {
        switch ($logModelName) {
            case '金子':
                $model = new PluginBullionLog();
                break;
            case '木材' :
                $model = new PluginWoodLog();
                break;
            case '肉' :
                $model = new PluginMeatLog();
                break;
            default:
                $model = new PluginWoodLog();
        }
        return $model;
    }
}

if (!function_exists('isAgent')) {
    /**
     * 是否是代理商
     * @return bool
     */
    function isAgent(): bool
    {
        return Admin::user()->cannot('admin') && Admin::user()->cannot('administrator');
    }
}

if (!function_exists('isWangbo')) {
    /**
     * 是否是王波
     * @return false
     */
    function isWangbo()
    {
        if (Admin::user()['username'] !== 'wangbo' && Admin::user()['username'] !== 'root') {
            return Administrator::where('username', 'wangbo')->value('id');
        }
        return false;
    }
}


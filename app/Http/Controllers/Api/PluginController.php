<?php
/**
 * @Author zayn
 * @Date 2021/11/11 16:58
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PluginAccount;
use App\Models\PluginBullionLog;
use App\Models\PluginEquipment;
use App\Models\PluginMeatLog;
use App\Models\PluginWoodLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PluginController extends Controller
{
    /**
     * 登录
     * @return array|void
     * @author zayn
     * @date 2021-11-15
     */
    public function login()
    {
        $data = [
            'account'  => request()->post('account'),
            'password' => request()->post('password')
        ];
        if (!Auth::attempt($data)) return fail([], '账号或密码错误');

        $user = PluginAccount::find(Auth::user()['account_id']);
        if ($user['state'] === 0) return fail([], '你已被禁用');

        $user->script_state = 1;
        if ($user->save()) return success([
            'account'   => $user['account'],
            'api_token' => $user['api_token'],
            'games'     => json_decode($user['games'], true)
        ]);

        return fail([], '服务异常');
    }

    /**
     * 状态改变
     * @return array|void
     * @author zayn
     * @date 2021-11-15
     */
    public function changeState()
    {
        $action = request()->post('action');
        $state = request()->post('state');
        $user = PluginAccount::find(Auth::user()['account_id']);
        switch ($action) {
            case 'state':
                $update_field = 'state';
                break;
            case 'scriptState':
                $update_field = 'script_state';
                break;
            case 'gameState':
                $update_field = 'game_state';
                break;
            default:
                return fail([], '无效的状态');
        }
        $user[$update_field] = $state;
        if ($action == 'scriptState' && $state == 2) {
            if (request()->post('gameAccount') && request()->post('gameAccount') !== Auth::user()['game_account']) {
                return fail(request()->post(), '钱包地址错误', 402);
            }
            $user->start_date = date('Y-m-d H:i:s');
        }
        if ($res = $user->save()) return success($res);
        return fail($res, 'change fail');
    }

    /**
     * 新增日志
     * @return array
     * @author zayn
     * @date 2021-11-15
     */
    public function addLog(): array
    {
        $post = request()->post();
        $account_id = Auth::user()['account_id'];
        $user_id = Auth::user()->user->id;
        foreach ($post['data'] as $item) {
            switch ($item['type']) {
                case 'bullion':
                    $model = new PluginBullionLog();
                    break;
                case 'wood':
                    $model = new PluginWoodLog();
                    break;
                case 'meat':
                    $model = new PluginMeatLog();
                    break;
                default:
                    $model = new PluginWoodLog();
            }
            $latest = $model->whereAccountId($account_id)
                ->orderByDesc('created_at')
                ->limit(1)->first();
            $model->account_id = Auth::user()['account_id'];
            $model->user_id = $user_id;
            $model->amount = $item['amount'];
            $model->diff = $latest ? bcsub($item['amount'], $latest->amount, 4) : 0;
            $model->save();
        }
        return success();
    }

    /**
     * 获取日志
     * @return array
     * @author zayn
     * @date 2021-11-17
     */
    public function getLog(): array
    {
        $type = request()->get('type');
        switch ($type) {
            case 'bullion':
                $tableModel = new PluginBullionLog();
                break;
            case 'wood':
                $tableModel = new PluginWoodLog();
                break;
            case 'meat':
                $tableModel = new PluginMeatLog();
                break;
            default:
                $tableModel = new PluginWoodLog();
        }
        return success($tableModel->orderByDesc('created_at')
            ->where('account_id', Auth::user()['account_id'])
            ->where('created_at', '>', Carbon::now()->toDateString())
            ->get());
    }

    /**
     * 获取账号信息
     * @return array
     * @author zayn
     * @date 2021-11-17
     */
    public function getAccountInfo(): array
    {
        return success([
            'account' => Auth::user()['account'],
            'games'   => json_decode(Auth::user()['games'], true)
        ]);
    }

    /**
     * 初始化装备
     * @return array
     * @throws \Exception
     * @author zayn
     * @date 2021-11-17
     */
    public function initEquipment(): array
    {
        $data = request()->post('data');
//        if ($count = PluginEquipment::whereAccountId(Auth::user()['account_id'])->count()) {
//            if (count($data) < $count) {
//                $user = PluginAccount::whereAccountId(Auth::user()['account_id'])->first();
//                $user->state = 2;
//                $user->save();
//            }
//        }
        PluginEquipment::whereAccountId(Auth::user()['account_id'])->delete();
        $account_id = Auth::user()['account_id'];

        foreach ($data as $mapIndex => $mapData) {
            foreach ($mapData as $info) {
                $equipment = new PluginEquipment();
                $equipment->account_id = $account_id;
                $equipment->map_index = $mapIndex;
                $equipment->name = $info['name'];
                $equipment->durable = $info['durable'] ?? '';
                $equipment->grade = $info['level'] ?? '';
                $equipment->content = $info['content'];
                $equipment->save();
            }
        }
        return success();
    }
}

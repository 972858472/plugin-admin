<?php

namespace App\Models;

use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PluginAccount
 *
 * @property int $account_id 账号ID
 * @property string $account 账号
 * @property string $password 密码
 * @property int $state 状态{0:"禁用",1:"正常"}
 * @property int|null $script_state 脚本状态{0:"未登录",1:"登录未使用",2:"开挂中"}
 * @property int|null $game_state 游戏状态{0:"正常",1:"异常"}
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount newQuery()
 * @method static \Illuminate\Database\Query\Builder|PluginAccount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereGameState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereScriptState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PluginAccount withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PluginAccount withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $api_token
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereApiToken($value)
 * @property string|null $start_date 开启脚本时间
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereStartDate($value)
 * @property int|null $user_id 代理商ID
 * @property string|null $game_account 钱包地址
 * @property-read Administrator|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereGameAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereUserId($value)
 * @property string|null $games 游戏ID
 * @method static \Illuminate\Database\Eloquent\Builder|PluginAccount whereGames($value)
 */
class PluginAccount extends Model implements AuthenticatableContract
{
    use Authenticatable,
        SoftDeletes;

    const DEFAULT_ID = 1;

    protected $fillable = ['account', 'password'];

    protected $table = 'plugin_account';

    protected $primaryKey = 'account_id';

    public function user()
    {
        return $this->belongsTo(Administrator::class, 'user_id', 'id');
    }
}

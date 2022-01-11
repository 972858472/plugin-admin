<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PluginMeatLog
 *
 * @property int $meat_log_id
 * @property int $account_id 账号ID
 * @property string|null $amount 数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog newQuery()
 * @method static \Illuminate\Database\Query\Builder|PluginMeatLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog whereMeatLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PluginMeatLog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PluginMeatLog withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $diff 差
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog whereDiff($value)
 * @property int|null $user_id 代理商ID
 * @method static \Illuminate\Database\Eloquent\Builder|PluginMeatLog whereUserId($value)
 */
class PluginMeatLog extends Model
{
	
    use SoftDeletes;

    protected $table = 'plugin_meat_log';

    protected $primaryKey = 'meat_log_id';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PluginBullionLog
 *
 * @property int $bullion_log_id
 * @property int $account_id 账号ID
 * @property string|null $amount 数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog newQuery()
 * @method static \Illuminate\Database\Query\Builder|PluginBullionLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog whereBullionLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PluginBullionLog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PluginBullionLog withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $diff 差
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog whereDiff($value)
 * @property int|null $user_id 代理商ID
 * @method static \Illuminate\Database\Eloquent\Builder|PluginBullionLog whereUserId($value)
 */
class PluginBullionLog extends Model
{
	
    use SoftDeletes;

    protected $table = 'plugin_bullion_log';

    protected $primaryKey = 'bullion_log_id';
}

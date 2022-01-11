<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PluginWoodLog
 *
 * @property int $wood_log_id
 * @property int $account_id 账号ID
 * @property string|null $amount 数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog newQuery()
 * @method static \Illuminate\Database\Query\Builder|PluginWoodLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog whereWoodLogId($value)
 * @method static \Illuminate\Database\Query\Builder|PluginWoodLog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PluginWoodLog withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $diff 差
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog whereDiff($value)
 * @property int|null $user_id 代理商ID
 * @method static \Illuminate\Database\Eloquent\Builder|PluginWoodLog whereUserId($value)
 */
class PluginWoodLog extends Model
{
	
    use SoftDeletes;

    protected $table = 'plugin_wood_log';

    protected $primaryKey = 'wood_log_id';
}

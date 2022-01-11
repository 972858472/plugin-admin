<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PluginEquipment
 *
 * @property int $account_id 账号ID
 * @property string|null $name 装备名称
 * @property string|null $grade 装备等级
 * @property string|null $content 内容属性
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment whereName($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment whereUpdatedAt($value)
 * @property int|null $map_index 地图index
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment whereMapIndex($value)
 * @property string|null $durable 耐久/进度
 * @method static \Illuminate\Database\Eloquent\Builder|PluginEquipment whereDurable($value)
 */
class PluginEquipment extends Model
{

    protected $table = 'plugin_equipment';

    protected $primaryKey = '';

    protected $casts = [
        'content' => 'json'
    ];

    public $incrementing = false;
}

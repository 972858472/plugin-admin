<?php

namespace App\Admin\Repositories;

use App\Models\PluginEquipment as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class PluginEquipment extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}

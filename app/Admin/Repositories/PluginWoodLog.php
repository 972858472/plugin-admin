<?php

namespace App\Admin\Repositories;

use App\Models\PluginWoodLog as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class PluginWoodLog extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}

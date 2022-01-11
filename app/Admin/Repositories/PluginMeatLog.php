<?php

namespace App\Admin\Repositories;

use App\Models\PluginMeatLog as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class PluginMeatLog extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}

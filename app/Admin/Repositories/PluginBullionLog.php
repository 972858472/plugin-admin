<?php

namespace App\Admin\Repositories;

use App\Models\PluginBullionLog as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class PluginBullionLog extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}

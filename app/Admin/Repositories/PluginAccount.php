<?php

namespace App\Admin\Repositories;

use App\Models\PluginAccount as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class PluginAccount extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}

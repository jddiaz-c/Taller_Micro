<?php

namespace App\Scrum\Presentation\Repositories;

use App\Scrum\Controllers\Retro_ItemsController;

class Retro_ItemsRepository extends BaseRepository
{
    protected function getController()
    {
        return new Retro_ItemsController();
    }
}
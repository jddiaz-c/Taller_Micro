<?php

namespace App\Scrum\Presentation\Repositories;
use App\Scrum\Controllers\SprintsController;

class SprintsRepository extends BaseRepository
{
    protected function getController()
    {
        return new SprintsController();
    }
}
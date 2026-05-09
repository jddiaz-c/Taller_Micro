<?php

use Slim\App;
use App\Scrum\Presentation\Repositories\SprintsRepository;
use App\Scrum\Presentation\Repositories\Retro_ItemsRepository;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/sprints', function (RouteCollectorProxy $group) {
        $group->get('', [SprintsRepository::class, 'all']);
        $group->get('/{id}', [SprintsRepository::class, 'detail']);
        $group->post('', [SprintsRepository::class, 'create']);
        $group->put('/{id}', [SprintsRepository::class, 'update']);
        $group->delete('/{id}', [SprintsRepository::class, 'delete']);
    });
    $app->group('/retro_items', function (RouteCollectorProxy $group) {
        $group->get('', [Retro_ItemsRepository::class, 'all']);
        $group->get('/{id}', [Retro_ItemsRepository::class, 'detail']);
        $group->post('', [Retro_ItemsRepository::class, 'create']);
        $group->put('/{id}', [Retro_ItemsRepository::class, 'update']);
        $group->delete('/{id}', [Retro_ItemsRepository::class, 'delete']);
    });
};

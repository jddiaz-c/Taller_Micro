<?php

namespace App\Scrum\Presentation\Repositories;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Scrum\Controllers\SprintsController;
use Exception;

class SprintsRepository
{

    function all(Request $request, Response $response)
    {
        $controller = new SprintsController();
        $sprints = $controller->getSprints();
        $response->getBody()->write($sprints);
        return $response->withHeader("Content-Type", "application/json");
    }

    function create(Request $request, Response $response)
    {
        $bodyRequest = $request->getBody()->getContents();
        $data = json_decode($bodyRequest, true);
        $controller = new SprintsController();
        $sprint = $controller->guardarSprint($data);
        $response->getBody()->write($sprint);
        return $response
            ->withStatus(201)
            ->withHeader("Content-Type", "application/json");
    }

    function detail(Request $req, Response $resp, $args)
    {
        try {
            $id = $args['id'];

            $controller = new SprintsController();
            $sprint = $controller->getSprint($id);

            $resposeBody = $sprint->toJson();
            $resp->getBody()->write($resposeBody);
            return $resp->withHeader("Content-Type", "application/json");
        } catch (Exception $ex) {
            $resp->getBody()->write("Error: " . $ex->getMessage());
            $code = 400;
            if ($ex->getCode() == 1) {
                $code = 404;
            }
            return $resp->withStatus($code);
        }
    }

    function update(Request $req, Response $resp, $args)
    {
        try {
            $id = $args['id'];
            $body = $req->getBody()->getContents();
            $data = json_decode($body, true);

            $controller = new SprintsController();
            $sprint = $controller->modificarSprint($id, $data);

            $dataResponse = $sprint->toJson();
            $resp->getBody()->write($dataResponse);
            return $resp
                ->withStatus(200)
                ->withHeader("Content-Type", "application/json");
        } catch (Exception $ex) {
            $resp->getBody()->write("Error: " . $ex->getMessage());
            $code = 400;
            if ($ex->getCode() == 1) {
                $code = 404;
            }
            return $resp->withStatus($code);
        }
    }

    function delete(Request $req, Response $resp, $args)
    {
        try {
            $id = $args['id'];

            $controller = new SprintsController();
            $controller->borrarSprint($id);

            $dataResponse = json_encode(['mgs' => 'Sprint borrado']);
            $resp->getBody()->write($dataResponse);
            return $resp
                ->withStatus(200)
                ->withHeader("Content-Type", "application/json");
        } catch (Exception $ex) {
            $resp->getBody()->write("Error: " . $ex->getMessage());
            $code = 400;
            if ($ex->getCode() == 1) {
                $code = 404;
            }
            return $resp->withStatus($code);
        }
    }
}

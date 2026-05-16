<?php

namespace App\Scrum\Presentation\Repositories;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;

abstract class BaseRepository
{
    abstract protected function getController();

    protected function handleError(Response $resp, Exception $ex): Response
    {
        $code = 400;
        
        if ($ex->getCode() == 1) {
            $code = 404;
        }
        
        if ($ex->getCode() == 0) {
            $resp->getBody()->write(json_encode([
                'error' => 'Error interno del servidor',
                'detalle' => $ex->getMessage()
            ]));
            return $resp->withStatus(500)->withHeader("Content-Type", "application/json");
        }

        $resp->getBody()->write(json_encode([
            'error' => $ex->getMessage()
        ]));
        return $resp->withStatus($code)->withHeader("Content-Type", "application/json");
    }
    
    function all(Request $req, Response $resp)
    {
        try {
            $data = $this->getController()->getAll();
            $resp->getBody()->write($data);
            return $resp->withHeader("Content-Type", "application/json");
        } catch (Exception $ex) {
            return $this->handleError($resp, $ex);
        }
    }

    function create(Request $req, Response $resp)
    {
        try {
            $data = json_decode($req->getBody()->getContents(), true);
            $result = $this->getController()->saveData($data);
            $resp->getBody()->write($result);
            return $resp->withStatus(201)->withHeader("Content-Type", "application/json");
        } catch (Exception $ex) {
            return $this->handleError($resp, $ex);
        }
    }

    function detail(Request $req, Response $resp, $args)
    {
        try {
            $result = $this->getController()->getOne($args['id']);
            $resp->getBody()->write($result->toJson());
            return $resp->withHeader("Content-Type", "application/json");
        } catch (Exception $ex) {
            return $this->handleError($resp, $ex);
        }
    }

    function update(Request $req, Response $resp, $args)
    {
        try {
            $data = json_decode($req->getBody()->getContents(), true);
            $result = $this->getController()->modify($args['id'], $data);
            $resp->getBody()->write($result->toJson());
            return $resp->withStatus(200)->withHeader("Content-Type", "application/json");
        } catch (Exception $ex) {
            return $this->handleError($resp, $ex);
        }
    }

    function delete(Request $req, Response $resp, $args)
    {
        try {
            $this->getController()->remove($args['id']);
            $resp->getBody()->write(json_encode(['msg' => 'Registro borrado']));
            return $resp->withStatus(200)->withHeader("Content-Type", "application/json");
        } catch (Exception $ex) {
            return $this->handleError($resp, $ex);
        }
    }
}
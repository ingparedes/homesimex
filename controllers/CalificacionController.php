<?php

namespace PHPMaker2021\simexamerica;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CalificacionController extends ControllerBase
{
    // list
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionList");
    }

    // add
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionAdd");
    }

    // view
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionView");
    }

    // edit
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionEdit");
    }

    // delete
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionDelete");
    }
}

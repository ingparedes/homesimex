<?php

namespace PHPMaker2021\simexamerica;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CalificacionEmailController extends ControllerBase
{
    // list
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionEmailList");
    }

    // add
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionEmailAdd");
    }

    // view
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionEmailView");
    }

    // edit
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionEmailEdit");
    }

    // delete
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CalificacionEmailDelete");
    }
}

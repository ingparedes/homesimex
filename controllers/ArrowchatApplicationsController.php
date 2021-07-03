<?php

namespace PHPMaker2021\simexamerica;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ArrowchatApplicationsController extends ControllerBase
{
    // list
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ArrowchatApplicationsList");
    }

    // add
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ArrowchatApplicationsAdd");
    }

    // view
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ArrowchatApplicationsView");
    }

    // edit
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ArrowchatApplicationsEdit");
    }

    // delete
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ArrowchatApplicationsDelete");
    }
}

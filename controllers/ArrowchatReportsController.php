<?php

namespace PHPMaker2021\simexamerica;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ArrowchatReportsController extends ControllerBase
{
    // list
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ArrowchatReportsList");
    }

    // add
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ArrowchatReportsAdd");
    }

    // view
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ArrowchatReportsView");
    }

    // edit
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ArrowchatReportsEdit");
    }

    // delete
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ArrowchatReportsDelete");
    }
}

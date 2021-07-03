<?php

namespace PHPMaker2021\simexamerica;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ImboxMailController extends ControllerBase
{
    // list
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImboxMailList");
    }

    // view
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImboxMailView");
    }

    // edit
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ImboxMailEdit");
    }
}

<?php

namespace PHPMaker2021\simexamerica;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * timeline_excon controller
 */
class TimelineExconController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TimelineExcon");
    }
}

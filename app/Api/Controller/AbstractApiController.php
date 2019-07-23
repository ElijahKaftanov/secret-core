<?php declare(strict_types=1);

namespace Classic\Secret\Core\Api\Controller;


use Classic\Secret\Core\Api\Foundation\Http\Response\ResponseBuilder;

abstract class AbstractApiController
{
    public function response(): ResponseBuilder
    {
        return new ResponseBuilder();
    }
}
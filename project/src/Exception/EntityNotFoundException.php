<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class EntityNotFoundException extends \Exception implements HttpExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return Response::HTTP_NOT_FOUND;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return [];
    }
}
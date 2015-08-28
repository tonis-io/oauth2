<?php
namespace Tonis\OAuth2\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

final class Test
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $token = $request->getAttribute('access_token');

        if ($token) {
            $data = $token;
        } else {
            $data = ['error' => 'The authorization server denied the request'];
        }

        return new JsonResponse($data);
    }
}

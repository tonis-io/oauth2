<?php
namespace Tonis\OAuth2;

use OAuth2\Request;
use OAuth2\Response;
use Psr\Http\Message\ServerRequestInterface;
use Tonis\Http\Response as TonisResponse;

class Util
{
    /**
     * Disallow construction.
     */
    private function __construct()
    {
    }

    /**
     * Takes an OAuth2 response and converts it to JSON output via Tonis\Http\Response.
     *
     * @param Response      $response
     * @param TonisResponse $tonisResponse
     * @return TonisResponse
     */
    public static function convertResponseToTonisJson(Response $response, TonisResponse $tonisResponse)
    {
        return $tonisResponse
            ->withStatus($response->getStatusCode())
            ->json($response->getParameters());
    }

    /**
     * Converts a PSR-7 request into an OAuth2 request.
     *
     * @param ServerRequestInterface $psrRequest
     * @return Request
     */
    public static function convertRequestFromPsr7(ServerRequestInterface $psrRequest)
    {
        return new Request(
            $psrRequest->getQueryParams(),
            is_array($psrRequest->getParsedBody()) ? $psrRequest->getParsedBody() : [],
            $psrRequest->getAttributes(),
            $psrRequest->getCookieParams(),
            self::getFiles($psrRequest->getUploadedFiles()),
            $psrRequest->getServerParams(),
            $psrRequest->getBody()->__toString()
        );
    }

    /**
     * @param array $uploadedFiles
     * @return array
     */
    private static function getFiles(array $uploadedFiles)
    {
        $files = [];
        foreach ($uploadedFiles as $key => $value) {
            $files[$key] = self::getFiles($value);
        }
        return $files;
    }
}
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
    public static function convertResponseToTonis(Response $response, TonisResponse $tonisResponse)
    {
        return $tonisResponse
            ->withStatus($response->getStatusCode());
    }

    /**
     * Converts a PSR-7 request into an OAuth2 request.
     *
     * @param ServerRequestInterface $psrRequest
     * @return Request
     */
    public static function convertRequestFromPsr7(ServerRequestInterface $psrRequest)
    {
        $headers = [];
        foreach ($psrRequest->getHeaders() as $header => $value) {
            $headers[$header] = implode(';', $value);
        }

        return new Request(
            $psrRequest->getQueryParams(),
            is_array($psrRequest->getParsedBody()) ? $psrRequest->getParsedBody() : [],
            $psrRequest->getAttributes(),
            $psrRequest->getCookieParams(),
            self::getFiles($psrRequest->getUploadedFiles()),
            $psrRequest->getServerParams(),
            $psrRequest->getBody()->__toString(),
            $headers
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
<?php
namespace Tonis\OAuth2;

use OAuth2\Request;
use OAuth2\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Util
{
    /**
     * Takes an OAuth2 response and converts it to JSON output via Tonis\Http\Response.
     *
     * @param Response          $oauthResponse
     * @param ResponseInterface $psrResponse
     * @return ResponseInterface
     */
    public static function convertResponseToPsr7(Response $oauthResponse, ResponseInterface $psrResponse)
    {
        $psrResponse = $psrResponse
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($oauthResponse->getStatusCode());

        $psrResponse->getBody()->write(json_encode($oauthResponse->getParameters()));

        foreach ($oauthResponse->getHttpHeaders() as $header => $value) {
            $psrResponse = $psrResponse->withHeader($header, $value);
        }

        return $psrResponse;
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

    /**
     * Disallow construction.
     */
    private function __construct()
    {
    }
}
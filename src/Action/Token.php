<?php
namespace Tonis\OAuth2\Action;

use OAuth2\Request as OAuth2Request;
use OAuth2\Server;
use Psr\Http\Message\UploadedFileInterface;
use Tonis\Http\Request;
use Tonis\Http\Response;
use Tonis\Middleware;

final class Token implements Middleware\RouterInterface
{
    /** @var Server */
    private $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        try {
            $oauth2request  = new OAuth2Request(
                $request->getQueryParams(),
                is_array($request->getParsedBody()) ? $request->getParsedBody() : [],
                $request->getAttributes(),
                $request->getCookieParams(),
                $this->getFiles($request->getUploadedFiles()),
                $request->getServerParams(),
                $request->getBody()->__toString()
            );
            $this->server->handleTokenRequest($oauth2request)->send();
            exit;
        } catch (\Exception $ex) {
            $response = $response->withStatus(400);

            $result = [
                'errors' => [
                    'title'   => $ex->getMessage(),
                    'details' => $ex->getTrace(),
                ],
            ];
        }

        return $response->json($result);
    }

    private function getFiles(array $uploadedFiles)
    {
        $files = array();
        foreach ($uploadedFiles as $key => $value) {
            if ($value instanceof UploadedFileInterface) {
                $files[$key] = $this->createUploadedFile($value);
            } else {
                $files[$key] = $this->getFiles($value);
            }
        }
        return $files;
    }
}

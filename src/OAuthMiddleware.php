<?php
namespace Tonis\OAuth2;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use OAuth2\Server;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OAuthMiddleware
{
    /** @var Server */
    private $server;
    /** @var array */
    private $config;
    /** @var EntityManager */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     * @param array         $config
     */
    public function __construct(EntityManager $entityManager, array $config)
    {
        $this->entityManager = $entityManager;

        $defaults = [
            'entity_namespace' => __NAMESPACE__,
            'entity_path'      => __DIR__ . '/Entity',

            'entities' => [
                Entity\OAuthAccessTokenInterface::class => Entity\OAuthAccessToken::class,
                Entity\OAuthClientInterface::class      => Entity\OAuthClient::class,
                Entity\OAuthUserInterface::class        => null,
            ],
        ];

        // config from sane defaults with overrides
        $this->config = array_replace_recursive($defaults, $config);

        $this->prepareEntityManager();
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if ($request->getUri()->getPath() === '/token') {
            $action = new Action\Token($this->getOAuthServer());
            return $action($request, $response, $next);
        }

        return $next($request, $response);
    }

    /**
     * @return Server
     */
    public function getOAuthServer()
    {
        if ($this->server) {
            return $this->server;
        }

        return $this->server = new Server([
            'access_token'       => $this->entityManager->getRepository(Entity\OAuthAccessTokenInterface::class),
            'client_credentials' => $this->entityManager->getRepository(Entity\OAuthClientInterface::class),
            'user_credentials'   => $this->entityManager->getRepository(Entity\OAuthUserInterface::class),
        ]);
    }

    /**
     * Prepare the EntityManager for OAuth entities and resolver.
     */
    protected function prepareEntityManager()
    {
        $resolver = new ResolveTargetEntityListener();

        foreach ($this->config['entities'] as $originalEntity => $newEntity) {
            $resolver->addResolveTargetEntity($originalEntity, $newEntity, []);
        }

        $this->entityManager->getEventManager()->addEventSubscriber($resolver);

        $driver = $this->entityManager->getConfiguration()->getMetadataDriverImpl();

        if (!$driver instanceof MappingDriverChain) {
            throw new \LogicException('OAuth2 requires a driver chain on the Entity Manager');
        }

        $driver->addDriver(new YamlDriver([__DIR__ . '/../config']), $this->config['entity_namespace']);
    }
}
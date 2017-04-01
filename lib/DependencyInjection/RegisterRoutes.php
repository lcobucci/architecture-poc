<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce\DependencyInjection;

use Lcobucci\SecretSauce\WriteOnly;
use Lcobucci\SecretSauce\ReadOnly;
use Lcobucci\SecretSauce\WriteRead;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterRoutes implements CompilerPassInterface
{
    const TYPES = [
        'read'       => ['methods' => ['GET'], 'callback' => 'readOnly'],
        'write'      => ['methods' => ['POST'], 'callback' => 'writeOnly'],
        'write_read' => ['methods' => ['PATCH', 'PUT'], 'callback' => 'writeRead'],
    ];

    /**
     * @var string
     */
    private $applicationId;

    /**
     * @var string
     */
    private $routerId;

    /**
     * @var string
     */
    private $routeTag;

    public function __construct(
        string $applicationId,
        string $routerId,
        string $routeTag = 'http_route'
    ) {
        $this->applicationId = $applicationId;
        $this->routerId      = $routerId;
        $this->routeTag      = $routeTag;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $api = $container->getDefinition($this->applicationId);

        foreach ($container->findTaggedServiceIds($this->routeTag) as $tags) {
            foreach ($tags as $tag) {
                $api->addMethodCall(
                    'route',
                    [
                        $tag['path'],
                        $this->createMiddleware($container, $tag),
                        self::TYPES[$tag['type']]['methods'],
                        $tag['id'],
                    ]
                );
            }
        }
    }

    private function createMiddleware(ContainerBuilder $container, array $route): string
    {
        $id = 'routes.' . $route['id'] . '.action';

        $definition = call_user_func([$this, self::TYPES[$route['type']]['callback']], $route);
        $container->setDefinition($id, $definition);

        return $id;
    }

    public function readOnly(array $route): Definition
    {
        return new Definition(
            ReadOnly::class,
            [new Reference($route['bus_read']), $route['query']]
        );
    }

    public function writeOnly(array $route): Definition
    {
        return new Definition(
            WriteOnly::class,
            [
                new Reference($route['bus_write']),
                new Reference($this->routerId),
                $route['command'],
                $route['routeName'],
            ]
        );
    }

    public function writeRead(array $route): Definition
    {
        return new Definition(
            WriteRead::class,
            [
                new Reference($route['bus_write']),
                new Reference($route['bus_read']),
                $route['command'],
                $route['query'],
            ]
        );
    }
}

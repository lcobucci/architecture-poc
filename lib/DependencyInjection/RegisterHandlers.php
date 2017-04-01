<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterHandlers implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $tag;

    public function __construct(string $tag = 'bus.handler')
    {
        $this->tag = $tag;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $locators = [];

        foreach ($container->findTaggedServiceIds($this->tag) as $id => $tags) {
            foreach ($tags as $tag) {
                $locators[$tag['locator']]                  = $locators[$tag['locator']] ?? [];
                $locators[$tag['locator']][$tag['handles']] = $id;
            }
        }

        foreach ($locators as $name => $handlers) {
            $locator = $container->getDefinition($name);

            $arguments    = $locator->getArguments();
            $arguments[1] = $handlers;

            $locator->setArguments($arguments);
        }
    }
}

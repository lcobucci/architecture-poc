<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Expressive\Router\RouterInterface;

final class WriteOnly implements MiddlewareInterface
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var string
     */
    private $command;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $routeName;

    public function __construct(
        CommandBus $commandBus,
        RouterInterface $router,
        string $command,
        string $routeName
    ) {
        $this->commandBus = $commandBus;
        $this->command    = $command;
        $this->router     = $router;
        $this->routeName  = $routeName;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $id = Uuid::uuid4();

        $this->commandBus->handle($this->command, $request, $id);

        return new EmptyResponse(
            201,
            ['Location' => $this->router->generateUri($this->routeName, ['id' => (string) $id])]
        );
    }
}

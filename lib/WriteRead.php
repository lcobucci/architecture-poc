<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

final class WriteRead implements MiddlewareInterface
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var string
     */
    private $command;

    /**
     * @var string
     */
    private $query;

    public function __construct(
        CommandBus $commandBus,
        QueryBus $queryBus,
        string $command,
        string $query
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
        $this->command    = $command;
        $this->query      = $query;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $this->commandBus->handle($this->command, $request);

        return new JsonResponse(
            $this->queryBus->handle($this->query, $request)
        );
    }
}

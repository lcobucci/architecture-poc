<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

final class ReadOnly implements MiddlewareInterface
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @var string
     */
    private $query;

    public function __construct(
        QueryBus $queryBus,
        string $query
    ) {
        $this->queryBus = $queryBus;
        $this->query    = $query;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        return new JsonResponse(
            $this->queryBus->handle($this->query, $request)
        );
    }
}

<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce\Tactician;

use Lcobucci\SecretSauce\QueryBus as QueryBusInterface;
use Psr\Http\Message\ServerRequestInterface;

final class QueryBus extends Adapter implements QueryBusInterface
{
    public function handle(
        string $query,
        ServerRequestInterface $request,
        ...$extra
    ) {
        return $this->commandBus->handle(
            $this->messageCreator->create($query, $request, ...$extra)
        );
    }
}

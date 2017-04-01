<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce\Tactician;

use Lcobucci\SecretSauce\CommandBus as CommandBusInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CommandBus extends Adapter implements CommandBusInterface
{
    public function handle(
        string $command,
        ServerRequestInterface $request,
        ...$extra
    ): void {
        $this->commandBus->handle(
            $this->messageCreator->create($command, $request, ...$extra)
        );
    }
}

<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker\Message;

use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ReturnBike
{
    public $id;

    public static function fromRequest(ServerRequestInterface $request): self
    {
        return new self(
            Uuid::fromString($request->getAttribute('id'))
        );
    }

    private function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }
}

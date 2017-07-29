<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker\Message;

use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class RentBike
{
    public $id;

    public $riderId;

    public $bikeId;

    public static function fromRequest(ServerRequestInterface $request, UuidInterface $id): self
    {
        $data = json_decode((string) $request->getBody(), true);

        return new self(
            $id,
            Uuid::fromString($data['rider']),
            Uuid::fromString($data['bike'])
        );
    }

    private function __construct(UuidInterface $id, UuidInterface $riderId, UuidInterface $bikeId)
    {
        $this->id      = $id;
        $this->riderId = $riderId;
        $this->bikeId  = $bikeId;
    }
}

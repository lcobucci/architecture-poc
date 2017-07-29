<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker\Message;

use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class AddCredit
{
    public $id;

    public $riderId;

    public $amount;

    public static function fromRequest(ServerRequestInterface $request, UuidInterface $id): self
    {
        $data = json_decode((string) $request->getBody(), true);

        return new self(
            $id,
            Uuid::fromString($request->getAttribute('rider_id')),
            $data['amount'] ?? 0
        );
    }

    private function __construct(UuidInterface $id, UuidInterface $riderId, float $amount)
    {
        assert($amount > 0, 'You stupid, you must pass a positive amount');

        $this->id      = $id;
        $this->riderId = $riderId;
        $this->amount  = $amount;
    }
}

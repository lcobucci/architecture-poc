<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Transaction
{
    private $id;

    private $rider;

    private $date;

    private $amount;

    public static function credit(UuidInterface $id, Rider $rider, float $amount): self
    {
        return new self(
            $id,
            $rider,
            new \DateTimeImmutable(),
            $amount
        );
    }

    public static function debit(UuidInterface $id, Rider $rider, float $amount): self
    {
        return new self(
            $id,
            $rider,
            new \DateTimeImmutable(),
            -$amount
        );
    }

    public function __construct(UuidInterface $id, Rider $rider, \DateTimeImmutable $date, float $amount)
    {
        $this->id     = $id;
        $this->rider  = $rider;
        $this->date   = $date;
        $this->amount = $amount;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function riderId(): UuidInterface
    {
        return $this->rider->id();
    }

    public function belongsTo(UuidInterface $riderId): bool
    {
        return $riderId->equals($this->rider->id());
    }

    public function date(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function amount(): float
    {
        return $this->amount;
    }
}

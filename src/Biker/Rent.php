<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

use Ramsey\Uuid\UuidInterface;

final class Rent
{
    private const PRICE_PER_HOUR = 0.5;

    private $id;

    private $rider;

    private $bike;

    private $rentedAt;

    private $returnedAt;

    public static function forRider(UuidInterface $id, Rider $rider, Bike $bike): self
    {
        $bike->lock();

        return new self($id, $rider, $bike, new \DateTimeImmutable(), null);
    }

    public function __construct(
        UuidInterface $id,
        Rider $rider,
        Bike $bike,
        \DateTimeImmutable $rentedAt,
        ?\DateTimeImmutable $returnedAt
    ) {
        $this->id         = $id;
        $this->rider      = $rider;
        $this->bike       = $bike;
        $this->rentedAt   = $rentedAt;
        $this->returnedAt = $returnedAt;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function rider(): Rider
    {
        return $this->rider;
    }

    public function riderId(): UuidInterface
    {
        return $this->rider->id();
    }

    public function bike(): Bike
    {
        return $this->bike;
    }

    public function bikeId(): UuidInterface
    {
        return $this->bike->id();
    }

    public function rentedAt(): \DateTimeImmutable
    {
        return $this->rentedAt;
    }

    public function returnedAt(): ?\DateTimeImmutable
    {
        return $this->returnedAt;
    }

    public function giveBack(): void
    {
        $this->returnedAt = new \DateTimeImmutable();

        $this->bike->unlock();
    }

    public function price(): float
    {
        assert($this->returnedAt);

        return $this->rentedHours() * self::PRICE_PER_HOUR;
    }

    private function rentedHours(): int
    {
        $rentedTimeInSeconds = $this->returnedAt->getTimestamp() - $this->rentedAt->getTimestamp();

        return (int) ceil($rentedTimeInSeconds / 3600);
    }
}

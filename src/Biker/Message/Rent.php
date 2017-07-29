<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker\Message;

use Lcobucci\Sample\Biker\Bike;
use Lcobucci\Sample\Biker\Rider;
use Ramsey\Uuid\UuidInterface;

final class Rent implements \JsonSerializable
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var Rider
     */
    public $rider;

    /**
     * @var Bike
     */
    public $bike;

    /**
     * @var \DateTimeImmutable
     */
    public $rentedAt;

    /**
     * @var \DateTimeImmutable
     */
    public $returnedAt;

    public static function fromEntity(\Lcobucci\Sample\Biker\Rent $rent): self
    {
        $dto = new self();
        $dto->id = $rent->id();
        $dto->rider = $rent->rider();
        $dto->bike = $rent->bike();
        $dto->rentedAt = $rent->rentedAt();
        $dto->returnedAt = $rent->returnedAt();

        return $dto;
    }

    public function jsonSerialize()
    {
        return [
            'id'          => (string) $this->id,
            'rider_id'    => (string) $this->rider->id(),
            'bike_id'     => (string) $this->bike->id(),
            'rented_at'   => $this->rentedAt->format(\DateTime::RFC3339),
            'returned_at' => $this->returnedAt ? $this->returnedAt->format(\DateTime::RFC3339) : null,
        ];
    }
}

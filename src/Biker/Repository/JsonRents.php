<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker\Repository;

use Lcobucci\Sample\Biker\BikeList;
use Lcobucci\Sample\Biker\RentNotFound;
use Lcobucci\Sample\Biker\RiderList;
use Lcobucci\Sample\Biker\Rent;
use Lcobucci\Sample\Biker\RentList;
use Lcobucci\Sample\NaiveJsonRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class JsonRents extends NaiveJsonRepository implements RentList
{
    /**
     * @var RiderList
     */
    private $riders;

    /**
     * @var BikeList
     */
    private $bikes;

    public function __construct(string $filename, RiderList $riders, BikeList $bikes)
    {
        $this->riders = $riders;
        $this->bikes = $bikes;

        parent::__construct($filename);
    }

    public function append(Rent $rent): void
    {
        $this->items[] = $rent;
        $this->changed = true;
    }

    public function get(UuidInterface $id): Rent
    {
        if (! isset($this->items[(string) $id])) {
            throw RentNotFound::forId($id);
        }

        return $this->items[(string) $id];
    }

    protected function convertItemToObject(array $item)
    {
        return new Rent(
            Uuid::fromString($item['id']),
            $this->riders->get(Uuid::fromString($item['rider'])),
            $this->bikes->get(Uuid::fromString($item['bike'])),
            new \DateTimeImmutable($item['rentedAt']),
            $item['returnedAt'] ? new \DateTimeImmutable($item['returnedAt']) : null
        );
    }

    /**
     * @param Rent $object
     */
    protected function convertObjectToItem($object): array
    {
        return [
            'id'         => (string) $object->id(),
            'rider'      => (string) $object->riderId(),
            'bike'       => (string) $object->bikeId(),
            'rentedAt'   => $object->rentedAt()->format(\DateTime::RFC3339),
            'returnedAt' => $object->returnedAt() ? $object->returnedAt()->format(\DateTime::RFC3339) : null,
        ];
    }
}

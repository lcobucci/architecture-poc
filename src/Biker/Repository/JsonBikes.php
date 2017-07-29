<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker\Repository;

use Lcobucci\Sample\Biker\Bike;
use Lcobucci\Sample\Biker\BikeList;
use Lcobucci\Sample\Biker\BikeNotFound;
use Lcobucci\Sample\NaiveJsonRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class JsonBikes extends NaiveJsonRepository implements BikeList
{
    /**
     * @throws BikeNotFound
     */
    public function get(UuidInterface $id): Bike
    {
        if (! isset($this->items[(string) $id])) {
            throw BikeNotFound::forId($id);
        }

        return $this->items[(string) $id];
    }

    protected function convertItemToObject(array $item)
    {
        return new Bike(Uuid::fromString($item['id']), $item['locked']);
    }

    /**
     * @param Bike $object
     *
     * @return array
     */
    protected function convertObjectToItem($object): array
    {
        return [
            'id'     => (string) $object->id(),
            'locked' => $object->isLocked(),
        ];
    }
}

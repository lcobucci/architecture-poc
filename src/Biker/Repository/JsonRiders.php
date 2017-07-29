<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker\Repository;

use Lcobucci\Sample\Biker\Rider;
use Lcobucci\Sample\Biker\RiderList;
use Lcobucci\Sample\Biker\RiderNotFound;
use Lcobucci\Sample\NaiveJsonRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class JsonRiders extends NaiveJsonRepository implements RiderList
{
    /**
     * @throws RiderNotFound
     */
    public function get(UuidInterface $id): Rider
    {
        if (! isset($this->items[(string) $id])) {
            throw RiderNotFound::forId($id);
        }

        return $this->items[(string) $id];
    }

    protected function convertItemToObject(array $item)
    {
        return new Rider(Uuid::fromString($item['id']), $item['name']);
    }

    /**
     * @param Rider $object
     *
     * @return array
     */
    protected function convertObjectToItem($object): array
    {
        return [
            'id'   => (string) $object->id(),
            'name' => $object->name(),
        ];
    }
}

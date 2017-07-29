<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App\Repository;

use Lcobucci\Sample\App\App;
use Lcobucci\Sample\App\Repository;
use Lcobucci\Sample\NaiveJsonRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Json extends NaiveJsonRepository implements Repository
{
    public function get(UuidInterface $id): App
    {
        if (!isset($this->items[(string) $id])) {
            throw new \RuntimeException('Not found');
        }

        return $this->items[(string) $id];
    }

    public function append(App $app): void
    {
        $this->items[] = $app;
    }

    protected function convertItemToObject(array $item): App
    {
        return new App(Uuid::fromString($item['id']), $item['name']);
    }

    /**
     * @param App $object
     *
     * @return array
     */
    protected function convertObjectToItem($object): array
    {
        return ['id' => (string) $object->id(), 'name' => $object->name()];
    }
}

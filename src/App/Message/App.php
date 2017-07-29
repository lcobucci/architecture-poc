<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App\Message;

use Lcobucci\Sample\App\App as Entity;
use Ramsey\Uuid\UuidInterface;

final class App implements \JsonSerializable
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    public static function fromEntity(Entity $app): self
    {
        $model       = new self();
        $model->id   = $app->id();
        $model->name = $app->name();

        return $model;
    }

    public function jsonSerialize()
    {
        return [
            'id'   => (string) $this->id,
            'name' => $this->name,
        ];
    }
}

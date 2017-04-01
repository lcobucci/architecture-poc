<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App\Message;

use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UpdateApp
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $id   = Uuid::fromString($request->getAttribute('id'));
        $data = json_decode((string) $request->getBody(), true);

        return new self($id, $data['name']);
    }

    private function __construct(UuidInterface $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }
}

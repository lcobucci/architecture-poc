<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App\Message;

use Psr\Http\Message\RequestInterface;
use Ramsey\Uuid\UuidInterface;

final class CreateApp
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    public static function fromRequest(RequestInterface $request, UuidInterface $id): self
    {
        $data = json_decode((string) $request->getBody(), true);

        return new self($id, $data['name']);
    }

    private function __construct(UuidInterface $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }
}

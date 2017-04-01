<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce\MessageCreator;

use Lcobucci\SecretSauce\MessageCreator;
use Psr\Http\Message\ServerRequestInterface;

final class NamedConstructor implements MessageCreator
{
    /**
     * @var string
     */
    private $methodName;

    public function __construct(string $methodName = 'fromRequest')
    {
        $this->methodName = $methodName;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $message, ServerRequestInterface $request, ...$extra)
    {
        return call_user_func([$message, $this->methodName], $request, ...$extra);
    }
}

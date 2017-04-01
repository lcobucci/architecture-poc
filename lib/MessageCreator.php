<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce;

use Psr\Http\Message\ServerRequestInterface;

interface MessageCreator
{
    /**
     * @param string                 $message
     * @param ServerRequestInterface $request
     * @param array                  $extra
     *
     * @return object
     */
    public function create(
        string $message,
        ServerRequestInterface $request,
        ...$extra
    );
}

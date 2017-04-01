<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce;

use Psr\Http\Message\ServerRequestInterface;

interface QueryBus
{
    /**
     * @param string                 $query
     * @param ServerRequestInterface $request
     * @param array                  $extra
     *
     * @return mixed
     */
    public function handle(
        string $query,
        ServerRequestInterface $request,
        ...$extra
    );
}

<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce\ModelConversion;

use League\Tactician\Middleware;

final class ReadModelConverter implements Middleware
{
    /**
     * @param object   $query
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($query, callable $next)
    {
        $result = $next($query);

        return $this->convertResult($query, $result);
    }

    private function convertResult($query, $result)
    {
        if (! $query instanceof Query) {
            return $result;
        }

        $converter = $query->getReadModelConverter();

        if (! is_array($result)) {
            return $converter($result);
        }

        return array_map($converter, $result);
    }
}

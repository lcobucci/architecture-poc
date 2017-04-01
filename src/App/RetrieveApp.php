<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App;

use Lcobucci\Sample\App\Message\RetrieveApp as RetrieveAppQuery;

final class RetrieveApp
{
    /**
     * @var ApplicationRepository
     */
    private $apps;

    public function __construct(ApplicationRepository $apps)
    {
        $this->apps = $apps;
    }

    /**
     * TODO: move conversion to a query bus middleware
     */
    public function handle(RetrieveAppQuery $query): array
    {
        $app = $this->apps->get($query->id);

        return [
            'id'   => (string) $app->id(),
            'name' => $app->name(),
        ];
    }
}

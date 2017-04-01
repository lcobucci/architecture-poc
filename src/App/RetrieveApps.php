<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App;

final class RetrieveApps
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
    public function handle(): array
    {
        return array_map(
            function (App $app): array {
                return [
                    'id'   => (string) $app->id(),
                    'name' => $app->name(),
                ];
            },
            $this->apps->findAll()
        );
    }
}

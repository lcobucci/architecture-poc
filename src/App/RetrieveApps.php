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

    public function handle(): array
    {
        return $this->apps->findAll();
    }
}

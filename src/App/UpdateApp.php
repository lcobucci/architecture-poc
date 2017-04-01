<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App;

use Lcobucci\Sample\App\Message\UpdateApp as UpdateAppCommand;

final class UpdateApp
{
    /**
     * @var ApplicationRepository
     */
    private $apps;

    public function __construct(ApplicationRepository $apps)
    {
        $this->apps = $apps;
    }

    public function handle(UpdateAppCommand $command): void
    {
        $app = $this->apps->get($command->id);
        $app->rename($command->name);
    }
}

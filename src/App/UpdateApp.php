<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App;

use Lcobucci\Sample\App\Message\UpdateApp as UpdateAppCommand;

final class UpdateApp
{
    /**
     * @var Repository
     */
    private $apps;

    public function __construct(Repository $apps)
    {
        $this->apps = $apps;
    }

    public function handle(UpdateAppCommand $command): void
    {
        $app = $this->apps->get($command->id);
        $app->rename($command->name);
    }
}

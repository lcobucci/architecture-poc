<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App;

use Lcobucci\Sample\App\Message\CreateApp as CreateAppCommand;

final class CreateApp
{
    /**
     * @var ApplicationRepository
     */
    private $apps;

    public function __construct(ApplicationRepository $apps)
    {
        $this->apps = $apps;
    }

    public function handle(CreateAppCommand $command): void
    {
        $app = new App($command->id, $command->name);

        $this->apps->append($app);
    }
}

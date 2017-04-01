<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce\Tactician;

use League\Tactician\CommandBus as TacticianCommandBus;
use Lcobucci\SecretSauce\MessageCreator;

abstract class Adapter
{
    /**
     * @var TacticianCommandBus
     */
    protected $commandBus;

    /**
     * @var MessageCreator
     */
    protected $messageCreator;

    public function __construct(
        TacticianCommandBus $commandBus,
        MessageCreator $messageCreator
    ) {
        $this->commandBus     = $commandBus;
        $this->messageCreator = $messageCreator;
    }
}

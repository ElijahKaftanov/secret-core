<?php declare(strict_types=1);

namespace Classic\Secret\Core\Api\Controller;


use Classic\Secret\Core\Domain\System\SystemManager;

class ServerController
{
    public function getPublicKey()
    {
        return SystemManager::up()->getPublicKey();
    }
}
<?php declare(strict_types=1);

namespace Classic\Secret\Core\Domain\User;


use Classic\Secret\Core\Foundation\Architecture\ServiceTrait;
use Classic\Secret\Core\Model\User;
use Classic\Secret\Package\Crypt\EncryptorInterface;
use Classic\Secret\Package\Crypt\Operator\CryptoFactory;
use Classic\Secret\Package\Crypt\SignCheckerInterface;

class UserManager
{
    use ServiceTrait;

    public function getEncryptor(User $user): EncryptorInterface
    {
        return $this->getCryptFactory()->makeEncryptor($user->public_key);
    }

    public function getSignChecker(User $user) : SignCheckerInterface
    {
        return $this->getCryptFactory()->makeSignChecker($user->public_key);
    }

    private function getCryptFactory(): CryptoFactory
    {
        return \app(CryptoFactory::class);
    }
}
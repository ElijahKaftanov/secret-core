<?php declare(strict_types=1);

namespace Classic\Secret\Core\Domain\System;


use Classic\Secret\Core\Foundation\Architecture\ServiceTrait;
use Classic\Secret\Core\Repository\SystemRepository;
use Classic\Secret\Package\Crypt\Operator\CryptoFactory;
use ParagonIE\EasyRSA\EasyRSA;
use ParagonIE\EasyRSA\KeyPair;

class SystemManager
{
    use ServiceTrait;

    public function getPublicKey(): string
    {
        return $this->storage()->find('pair.public');
    }

    private function getPrivateKey(): string
    {
        return $this->storage()->find('pair.private');
    }

    public function decrypt(string $message): string
    {
        return $this->getCryptoFactory()
            ->makeDecryptor($this->getPrivateKey())
            ->decrypt($message);
    }

    private function storage(): SystemRepository
    {
        return SystemRepository::up();
    }

    public function generateKeyPair()
    {
        $pair = KeyPair::generateKeyPair(4096);

        $this->storage()->set('pair', [
            'public' => $pair->getPublicKey()->getKey(),
            'private' => $pair->getPrivateKey()->getKey()
        ]);
    }

    private function getCryptoFactory(): CryptoFactory
    {
        return \app(CryptoFactory::class);
    }
}
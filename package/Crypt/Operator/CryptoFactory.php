<?php declare(strict_types=1);

namespace Classic\Secret\Package\Crypt\Operator;


class CryptoFactory
{
    public function makeEncryptor(string $publicKey)
    {
        return new PublicOperator($publicKey);
    }

    public function makeDecryptor(string $privateKey)
    {
        return new PrivateOperator($privateKey);
    }

    public function makeSignChecker(string $publicKey)
    {
        return new PublicOperator($publicKey);
    }

    public function makeSigner(string $privateKey)
    {
        return new PrivateOperator($privateKey);
    }
}
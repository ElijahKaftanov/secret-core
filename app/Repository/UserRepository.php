<?php declare(strict_types=1);

namespace Classic\Secret\Core\Repository;


use Classic\Secret\Core\Foundation\Architecture\ServiceTrait;
use Classic\Secret\Core\Model\User;

class UserRepository
{
    use ServiceTrait;

    public function findByUsername(string $name): ?User
    {
        /** @var User $user */
        $user = User::query()->where('username', $name)->first();

        return $user;
    }
}
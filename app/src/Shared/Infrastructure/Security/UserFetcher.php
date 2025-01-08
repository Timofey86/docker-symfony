<?php

namespace App\Shared\Infrastructure\Security;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Security\UserFetcherInterface;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\SecurityBundle\Security;


class UserFetcher implements UserFetcherInterface
{
    public function __construct(private Security $security)
    {
    }

    public function getAuthUser(): AuthUserInterface
    {

        $user = $this->security->getUser();


        Assert::assertNotNull($user, 'Current user is null. Make sure the authentication system is properly configured.');
        Assert::assertInstanceOf(AuthUserInterface::class, $user, 'The authenticated user does not implement AuthUserInterface.');
        return $user;
    }
}
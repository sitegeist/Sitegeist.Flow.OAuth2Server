<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Entities\UserEntityInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Security\Account;

class UserAdapter implements UserEntityInterface
{
    public function __construct(
        private readonly Account $account,
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->account->getAccountIdentifier();
    }
}

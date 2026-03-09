<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;

/**
 * @method ?RefreshToken findByIdentifier(string $identifier)
 */
#[Flow\Scope('singleton')]
class RefreshTokenRepository extends Repository implements RefreshTokenRepositoryInterface
{
    public function getNewRefreshToken(): RefreshTokenEntityInterface
    {
        return new RefreshToken();
    }

    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        $this->add($refreshTokenEntity);
    }

    public function revokeRefreshToken($tokenId): void
    {
        $token = $this->requireToken($tokenId);
        $token->setIsRevoked(true);
        $this->update($token);
    }

    public function isRefreshTokenRevoked($tokenId): bool
    {
        return $this->requireToken($tokenId)->isRevoked();
    }

    private function requireToken(string $tokenId): RefreshToken
    {
        $token = $this->findByIdentifier($tokenId);
        if ($token === null) {
            throw new \Exception('Unknown token ' . $tokenId);
        }

        return $token;
    }
}

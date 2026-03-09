<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;

/**
 * @method ?AuthCode findByIdentifier(string $identifier)
 */
#[Flow\Scope('singleton')]
class AuthCodeRepository extends Repository implements AuthCodeRepositoryInterface
{
    public function getNewAuthCode(): AuthCode
    {
        return new AuthCode();
    }

    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {
        $this->add($authCodeEntity);
    }

    public function revokeAuthCode($codeId): void
    {
        $authCode = $this->requireAuthCode($codeId);
        $authCode->setIsRevoked(true);
        $this->update($authCode);
    }

    public function isAuthCodeRevoked($codeId): bool
    {
        return $this->requireAuthCode($codeId)->isRevoked();
    }

    private function requireAuthCode(string $authCode): AuthCode
    {
        $authCode = $this->findByIdentifier($authCode);
        if ($authCode === null) {
            throw new \Exception('Unknown auth code ' . $authCode);
        }

        return $authCode;
    }
}

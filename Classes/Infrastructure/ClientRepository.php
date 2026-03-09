<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use Neos\Flow\Security\Cryptography\HashService;

/**
 * @method ?Client findOneByIdentifier(string $clientIdentifier)
 * @method ?Client findByIdentifier(string $clientIdentifier)
 */
#[Flow\Scope('singleton')]
class ClientRepository extends Repository implements ClientRepositoryInterface
{
    /**
     * @Flow\Inject
     * @var HashService
     */
    protected $hashService;

    public function getClientEntity($clientIdentifier): ?Client
    {
        $client = $this->findOneByIdentifier($clientIdentifier);

        return $client instanceof Client ? $client : null;
    }

    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        $clientEntity = $this->getClientEntity($clientIdentifier);

        if ($clientEntity === null) {
            return false;
        }

        if (!$clientEntity->isConfidential() || !$clientEntity->getSecret()) {
            return true;
        }

        if (!$clientSecret) {
            return false;
        }

        return $this->hashService->validatePassword(
            password: $clientSecret,
            hashedPasswordAndSalt: $clientEntity->getSecret(),
        );
    }
}

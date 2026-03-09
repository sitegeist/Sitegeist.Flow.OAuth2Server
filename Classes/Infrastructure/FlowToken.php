<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use Doctrine\Common\Collections\Collection;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\TokenInterface;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @property string $Persistence_Object_Identifier
 * @see TokenInterface
 */
trait FlowToken
{
    /**
     * @var \DateTimeImmutable
     */
    protected $expiryDateTime;

    /**
     * @phpstan-var string|null
     * @ORM\Column(nullable=true)
     * @var string
     */
    protected $userIdentifier;

    /**
     * @ORM\ManyToOne
     * @var Client
     */
    protected $client;

    /**
     * @phpstan-var Collection<int,Scope>
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Sitegeist\Flow\OAuth2Server\Infrastructure\Scope", cascade={"persist"})
     * @Flow\Lazy
     */
    protected $scopes;

    /**
     * @var bool
     */
    protected $isRevoked;

    public function getIdentifier(): string
    {
        return $this->getPersistenceObjectIdentifier();
    }

    public function setIdentifier($identifier): void
    {
        throw new \BadMethodCallException('changing identifiers is not supported');
    }

    public function getUserIdentifier(): ?string
    {
        return $this->userIdentifier;
    }

    /**
     * @param int|string|null $userIdentifier
     */
    public function setUserIdentifier($userIdentifier): void
    {
        if (is_int($userIdentifier)) {
            throw new \InvalidArgumentException('userIdentifier must be a string.', 1773059427);
        }
        $this->userIdentifier = $userIdentifier;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(ClientEntityInterface $client): void
    {
        if (!$client instanceof Client) {
            throw new \InvalidArgumentException('Flow OAuth tokens only accept concrete Flow clients', 1773059220);
        }
        $this->client = $client;
    }

    public function addScope(ScopeEntityInterface $scope): void
    {
        if (!$scope instanceof Scope) {
            throw new \InvalidArgumentException('Flow OAuth tokens only accept concrete Flow scopes', 1773059242);
        }
        $this->scopes->add($scope);
    }

    /**
     * @return array<int,Scope>
     */
    public function getScopes(): array
    {
        return $this->scopes->toArray();
    }

    public function getPersistenceObjectIdentifier(): string
    {
        /** @phpstan-ignore-next-line (magic property ¯\_(ツ)_/¯) */
        return $this->Persistence_Object_Identifier;
    }

    public function isRevoked(): bool
    {
        return $this->isRevoked;
    }

    public function setIsRevoked(bool $isRevoked): void
    {
        $this->isRevoked = $isRevoked;
    }
}

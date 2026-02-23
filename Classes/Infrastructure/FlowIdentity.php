<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @property string Persistence_Object_Identifier
 */
trait FlowIdentity
{
    /**
     * @var string
     * @Flow\Identity
     * @ORM\Column(name="identifier", type="string", length=255)
     */
    protected $identifier;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getPersistenceObjectIdentifier(): string
    {
        return $this->Persistence_Object_Identifier;
    }
}

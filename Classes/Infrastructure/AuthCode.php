<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 * @ORM\Table(
 *     name="sitegeist_flow_oauth2server_authcode",
 *     uniqueConstraints={
 *     },
 *     indexes={
 *     }
 * )
 */
class AuthCode implements AuthCodeEntityInterface
{
    use FlowToken, AuthCodeTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $redirectUri;

    public function getExpiryDateTime(): \DateTimeImmutable
    {
        return $this->expiryDateTime;
    }

    public function setExpiryDateTime(\DateTimeImmutable $dateTime): void
    {
        $this->expiryDateTime = $dateTime;
    }
}

<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Infrastructure;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 * @ORM\Table(
 *     name="sitegeist_flow_oauth2server_accesstoken"
 * )
 */
class AccessToken implements AccessTokenEntityInterface
{
    use FlowToken, AccessTokenTrait;

    public function setExpiryDateTime(\DateTimeImmutable $dateTime): void
    {
        $this->expiryDateTime = $dateTime;
    }

    public function getExpiryDateTime(): \DateTimeImmutable
    {
        return $this->expiryDateTime;
    }
}

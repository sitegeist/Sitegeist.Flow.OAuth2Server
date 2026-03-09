<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Application\Controller;

use GuzzleHttp\Psr7\Utils;
use League\OAuth2\Server\Exception\OAuthServerException;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\ActionRequest;
use Neos\Flow\Mvc\ActionResponse;
use Neos\Flow\Mvc\Controller\AbstractController;
use Sitegeist\Flow\OAuth2Server\AuthorizationServerFactory;
use Sitegeist\Flow\OAuth2Server\GrantType;

class AccessTokenController extends AbstractController
{
    public function __construct(
        private readonly AuthorizationServerFactory $authorizationServerFactory,
    ) {
    }

    public function processRequest(ActionRequest $request, ActionResponse $response): void
    {
        // @todo resolve grant type
        $server = $this->authorizationServerFactory->create(GrantType::AUTHORIZATION_CODE);

        try {
            $httpResponse = $server->respondToAccessTokenRequest($request->getHttpRequest(), $response->buildHttpResponse());
            $response->setContent($httpResponse->getBody());
            $response->setStatusCode($httpResponse->getStatusCode());
        } catch (OAuthServerException $exception) {
            $httpResponse = $exception->generateHttpResponse($response->buildHttpResponse());
            $response->setContent($httpResponse->getBody());
            $response->setStatusCode($httpResponse->getStatusCode());
        } catch (\Exception $exception) {
            $response->setContent(Utils::streamFor($exception->getMessage()));
            $response->setStatusCode(500);
        }
    }
}

<?php

declare(strict_types=1);

namespace Sitegeist\Flow\OAuth2Server\Application\Controller;

use GuzzleHttp\Psr7\Utils;
use League\OAuth2\Server\Exception\OAuthServerException;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\ActionRequest;
use Neos\Flow\Mvc\ActionResponse;
use Neos\Flow\Mvc\Controller\AbstractController;
use Neos\Flow\Security\Account;
use Neos\Flow\Security\Context as SecurityContext;
use Sitegeist\Flow\OAuth2Server\AuthorizationServerFactory;
use Sitegeist\Flow\OAuth2Server\GrantType;
use Sitegeist\Flow\OAuth2Server\Infrastructure\UserAdapter;

class AuthorizeController extends AbstractController
{
    public function __construct(
        private readonly AuthorizationServerFactory $authorizationServerFactory,
        private readonly SecurityContext $securityContext,
    ) {
    }

    public function processRequest(ActionRequest $request, ActionResponse $response): void
    {
        // @todo resolve grant type
        $server = $this->authorizationServerFactory->create(GrantType::AUTHORIZATION_CODE);

        try {
            $authRequest = $server->validateAuthorizationRequest($request->getHttpRequest());

            // Authentication is enforced by security
            /** @var ?Account $account */
            $account = $this->securityContext->getAccount();
            if (!$account) {
                throw new \Exception('Unauthorized');
            }
            $authRequest->setUser(new UserAdapter($account));

            // @todo actually ask for approval via form
            $authRequest->setAuthorizationApproved(true);

            $httpResponse = $server->completeAuthorizationRequest($authRequest, $response->buildHttpResponse());
            $response->setStatusCode($httpResponse->getStatusCode());
            $response->setContent($httpResponse->getBody());
        } catch (OAuthServerException $exception) {
            $httpResponse = $exception->generateHttpResponse($response->buildHttpResponse());
            $response->setStatusCode($httpResponse->getStatusCode());
            $response->setContent($httpResponse->getBody());
        } catch (\Exception $exception) {
            $response->setStatusCode(500);
            $response->setContent(Utils::streamFor($exception->getMessage()));
        }
    }
}

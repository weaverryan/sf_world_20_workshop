<?php

namespace App\Security;

use App\Entity\ApiToken;
use App\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;

class ApiTokenAuthenticator implements AuthenticatorInterface
{
    private $apiTokenRepository;

    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-TOKEN');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $token = $request->headers->get('X-TOKEN');

        $apiToken = $this->apiTokenRepository
            ->findOneBy(['token' => $token]);

        $passport = new SelfValidatingPassport(
            new UserBadge($token, function($token) use ($apiToken) {
                if (!$apiToken) {
                    throw new CustomUserMessageAuthenticationException('Invalid token');
                }

                return $apiToken->getUser();
            })
        );

        $passport->setAttribute('api_token', $apiToken);

        return $passport;
    }

    /**
     * @param SelfValidatingPassport $passport
     */
    public function createAuthenticatedToken(PassportInterface $passport, string $firewallName): TokenInterface
    {
        $apiToken = $passport->getAttribute('api_token');
        if (!$apiToken instanceof ApiToken) {
            throw new \Exception('something went funny');
        }

        $roles = $passport->getUser()->getRoles();
        foreach ($apiToken->getScopes() as $scope) {
            $roles[] = 'ROLE_SCOPE_'.strtoupper($scope);
        }

        return new PostAuthenticationToken($passport->getUser(), $firewallName, $roles);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['error' => $exception->getMessageKey()], 401);
    }
}

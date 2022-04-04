<?php

namespace App\Security;

use App\Exception\AuthenticateException;
use App\Helper\HttpExceptionResponse;
use App\Helper\HttpResponse;
use App\Service\Api\SecurityServiceApi;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class TokenAuthenticator extends AbstractAuthenticator
{
    /**
     * @var SecurityServiceApi
     */
    private SecurityServiceApi $securityServiceApi;

    public function __construct(SecurityServiceApi $securityServiceApi) {
        $this->securityServiceApi = $securityServiceApi;
    }

    public function supports(Request $request): ?bool
    {
        $url_supported = array(

        );

        return in_array($request->attributes->get("_route"), $url_supported);
    }

    /**
     * @param Request $request
     * @return Passport
     * @throws AuthenticateException
     */
    public function authenticate(Request $request) : Passport
    {
        if(!$request->headers->has("token")) {
            throw new AuthenticateException("Debe proporcionar un token de autorización");
        }

        $token = $request->headers->get("token");

        if(is_null($token)) {
            throw new AuthenticateException("Debe proporcionar un token de autorización válido");
        }

        return new SelfValidatingPassport(new UserBadge($token, function($userIdentifier) {
            return $this->securityServiceApi->apiUseValidate($userIdentifier);
        }));
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $firewallName
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return HttpResponse::forbidden($exception->getMessage());
    }
}
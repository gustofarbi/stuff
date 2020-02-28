<?php

namespace App\Security;

use App\Document\ApiToken;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class BaseAuthenticator extends AbstractGuardAuthenticator
{
    const AUTH_TOKEN_HEADER = 'X-AUTH-TOKEN';

    /**
     * @var DocumentManager
     */
    private DocumentManager $dm;

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(DocumentManager $dm, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->dm              = $dm;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        if (in_array($request->getPathInfo(),
                     [
                         '/api/login',
                         '/api/register',
//                         '/api/home',
                     ]
        )) {
            return false;
        }

        return true;
    }

    public function getCredentials(Request $request)
    {
        return [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
            'apiToken' => $request->headers->get(self::AUTH_TOKEN_HEADER),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $apiToken = $credentials['apiToken'];

        if ($apiToken === null) {
            return null;
        }

        return $this->dm->getRepository(ApiToken::class)->findOneBy(
            [
                'content' => $apiToken,
            ]
        )->getUser();
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'message' => 'Authentication required',
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }


}

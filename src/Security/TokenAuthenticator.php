<?php

/*
 * Handle Token Authentication
 */

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if (null === $credentials) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            return false;
        }

        return true;
    }

    public function getCredentials(Request $request)
    {
        return $request->headers->get('X-AUTH-TOKEN');
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        //if (null === $credentials) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
        //    throw new CustomUserMessageAuthenticationException('No API token provided');
        //}

        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['token' => $credentials])
        ;


        if (null === $user) {
            throw new CustomUserMessageAuthenticationException('No user Found');
        }

        // The "username" in this case is the token, see the key `property`
        // of `your_db_provider` in `security.yaml`.
        // If this returns a user, checkCredentials() is called next:
        return $user;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'error' => $exception->getMessageKey()
        ], 400);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return null;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse([
            'error' => 'Access Denied'
        ]);
    }

    public function supports(Request $request)
    {
        // look for header "X-AUTH-TOKEN: <token>"
        return $request->headers->has('X-AUTH-TOKEN');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}

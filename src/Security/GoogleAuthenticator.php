<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Profil;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;

/**
 * Created by IntelliJ IDEA
 * User : mert
 * Date : 12/18/17
 * Time: 12:00 PM
 */
class GoogleAuthenticator extends \KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator
{

    private $clientRegistry;
    private $em;
    private $router;

    public function  __construct(ClientRegistry $clientRegistry,EntityManagerInterface  $em , RouterInterface $router)
    {
        $this->clientRegistry=$clientRegistry;
        $this->em=$em;
        $this->router=$router;

    }


    /**
     * @inheritDoc
     */
    public function supports(Request $request)
    {
        return $request->getPathInfo()=='http://127.0.0.1:8000'&&$request->isMethod('GET');
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
       return $this->fetchAccessToken($this->getGoogleClient());
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GoogleUser $googleUser */
        $googleUser = $this->getGoogleClient()
            ->fetchUserFromToken($credentials);
        $email = $googleUser->getEmail();
        $user =$this->em->getRepository('App:User')
            ->findOneBy(['email'=>$email]);
       
        return $user;
    }

    /**
     * @return \KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface
     */
    private function getGoogleClient(): \KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface
    {
        return $this->clientRegistry
            ->getClient('google');
    }
    /**
     * @inheritDoc
     * @param Request $request The request that resulted in AuthenticationException
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $authException The exception that started
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function start(Request $request,\Symfony\Component\Security\Core\Exception\AuthenticationException $authException = null)
    {
        return new RedirectResponse('/login');
    }

    /**
     * @inheritDoc
     * @param Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function onAuthenticationFailure(Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $exception)
    {
        // TODO: Implement onAuthenticationFailure() method.
    }

    /**
     * @inheritDoc
     * @param Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     * @return void
     */
    public function onAuthenticationSuccess(Request $request, \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token, $providerKey)
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }




}
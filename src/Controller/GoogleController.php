<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     *
     *@Route ("/connect/google" , name="connect_google")
     *@param ClientRegistry $clientRegistry
     *@return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect();
    }
    /**
     *
     *
     * @Route ("http://127.0.0.1:8000", name="http://127.0.0.1:8000")
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction(Request $request)
    {
        if (!$this->getUser()){
            return new JsonResponse(array('status'=>false ,'message'=>"User Not Found"));
        }else{
            return $this->redirectToRoute('app-index');
        }
    }

}
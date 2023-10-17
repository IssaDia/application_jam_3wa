<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function api_login():Response
    {
      

        $user = $this->getUser();

        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);


    }
    #[Route('/logout', name: 'logout')]
    public function logout(){
        return new Response('Logged out successfully');
    }
}

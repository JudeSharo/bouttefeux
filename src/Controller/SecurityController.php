<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    
    #[Route('/login', name: 'app_login')]
     
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_profil');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/edit_user',name:'app_edit_user')]
    public function edit_user()
    {
        return $this->render('security/edit.html.twig');
    }

    #[Route('/destruct_user',name:'app_destruct_user')]
    public function supp_user()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        echo("Destruction de votre compte");
        return $this->render('profil/index.html.twig');
    }
}

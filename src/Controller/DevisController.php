<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevisController extends AbstractController
{
    #[Route('/devis', name: 'app_devis_index')]
    public function index(): Response
    {
    	$this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Image;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EventController extends AbstractController
{
    #[Route('/event/index', name: 'app_event_index')]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/event/new',name:'app_event_new')]
    public function new(Request $request):Response
    {
    	$event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form -> get('images')->getData();
            $entityManager = $this->getDoctrine()->getManager();
            foreach($images as $image)
            {
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                $image -> move(
                    $this->getParameter('image_directory'),
                    $fichier
                );

                $img = new Image();
                $img -> setSrc($fichier);
                $event ->addImage($img);
                $entityManager->persist($img);
            }
            
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }
     #[Route('/event/{id}/edit',name:'app_event_edit')]
    public function edit(Request $request,Event $event)
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $images = $form -> get('images')->getData();
            $entityManager = $this->getDoctrine()->getManager();
            foreach($images as $image)
            {
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                $image -> move(
                    $this->getParameter('image_directory'),
                    $fichier
                );

                $img = new Image();
                $img -> setSrc($fichier);
                $event ->addImage($img);
                $entityManager->persist($img);
            }
            
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index');
        }
        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Image;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\isCsrfTokenValid;
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
    	$this->denyAccessUnlessGranted('ROLE_ADMIN');
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form -> get('images')->getData();
            $entityManager = $this->getDoctrine()->getManager();
            if(count($images)>3)
            {
                for($i = 0;$i<3;$i++)
                {
                    $image = $images[$i];
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
            }
            else
            {
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
            }
            $event->setDatetime(new \Datetime('@'.strtotime('now')));
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
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

    #[Route('/event/{id}/show',name:'app_event_show')]
    public function show(Event $event)
    {
        return $this->render('event/show.html.twig',['event' => $event,]);
    }

    #[Route('/event/image/{id}/delete',name:'app_event_image_delete',methods:['DELETE'])]
    public function deleteImage(Image $image, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $data = json_decode($request->getContent(),true);

        if($this -> isCsrfTokenValid('delete'.$image->getId(),$data['token']))
        {
            $nom = $image ->getSrc();

            unlink($this ->getParameter('image_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            return new JsonResponse(['sucess'=>1]);

        }
        else
        {
            return new JsonResponse(['error'=>'Token invalide'],400);
        }
    }
    #[Route('/event/{id}/delete',name:'app_event_delete',methods:['POST'])]
    public function deleteEvent(Event $event)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $images= $event ->getImage();  
            if($images)
            {
                foreach($images as $image)
                {
                    $nom = $image ->getSrc();
                    $nomImage= $this ->getParameter('image_directory').'/'.$nom;
                    if(file_exists($nomImage))
                    {
                        unlink($nomImage);
                        $em = $this->getDoctrine()->getManager();
                        $em->remove($image);
                        $em->flush();
                    }
                }
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        return $this->redirectToRoute('index');
    }
}
 
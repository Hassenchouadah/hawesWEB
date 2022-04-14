<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Messages;
use App\Entity\Utilisateurs;
use App\Form\MessageType;

class MessageController extends AbstractController
{
    
    /**
     * @Route("/admin/messages/{friendId}", name="admin_messages")
     */
    public function index($friendId,Request $request): Response
    {
        $connectedId =1;
        $connected = $this->getDoctrine()->getRepository(Utilisateurs::class)->find($connectedId);
        $friend = $this->getDoctrine()->getRepository(Utilisateurs::class)->find($friendId);
        $messages = $this->getDoctrine()->getRepository(Messages::class)->getMessages($connectedId,$friendId);
        $newMessage = new Messages();
        $form = $this->createForm(MessageType::class, $newMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newMessage->setCreated(new \DateTime('now'));
            $newMessage->setSeen(0);
            $newMessage->setSender($connected);
            $newMessage->setType("message");
            $newMessage->setReceiver($friend);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newMessage);
            $entityManager->flush();


            return $this->redirectToRoute('admin_messages', ['friendId' => $friendId]);

        }
        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'friend' => $friend,
            'currentDate' => new \DateTime('now'),
            'messageForm' => $form->createView()
        ]);
        
    }
    /**
    * @Route("/admin/deleteMessage/{friendId}/{id}", name="delete_message")
    */
    public function deleteMessage($friendId,$id){
        $em = $this->getDoctrine()->getManager();
        $message = $this->getDoctrine()->getRepository(Messages::class)->find($id);
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute('admin_messages', ['friendId' => $friendId]);

    }
}

<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Utilisateur;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class MessagesController extends AbstractController
{
    /**
     * @Route("/admin/messages/{friendId}", name="admin_messages")
     */
    public function index($friendId,Request $request): Response
    {
        $connectedId = $this->getUser()->getId();
        $friend = $this->getDoctrine()->getRepository(Utilisateur::class)->find($friendId);

        $messages = $this->getDoctrine()->getRepository(Messages::class)->getMessages($connectedId,$friendId);

        $newMessage = new Messages();

        $form = $this->createForm(MessageType::class, $newMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newMessage->setCreated(new \DateTime('now'));
            $newMessage->setSeen(0);
            $newMessage->setSender($this->getUser());
            $newMessage->setType("text");
            $newMessage->setReceiver($friend);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newMessage);
            $entityManager->flush();


            return $this->redirectToRoute('admin_messages', ['friendId' => $friendId]);

        }
        return $this->render('messages/index.html.twig', [
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

<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class ChatController extends AbstractController
{
    /**
     * @Route("/chat", name="app_chat")
     */
    public function index(): Response
    {

        $em = $this->getDoctrine()->getManager();
        $activeFriend=$this->getUser();
        $users = $em->getRepository(Utilisateur::class)->findAll();


        $messages = $this->getDoctrine()->getRepository(Messages::class)->getMessages($activeFriend->getId(),$activeFriend->getId());

        return $this->render('chat/index.html.twig', [
            'users' => $users,
            'messages' => $messages,
            "activeFriend" => $activeFriend
        ]);
    }


    /**
     * @Route("/chat/{friendId}", name="app_discussion")
     */
    public function getMessages($friendId): Response
    {

        $em = $this->getDoctrine()->getManager();
        $activeFriend=$em->getRepository(Utilisateur::class)->find($friendId);

        $users = $em->getRepository(Utilisateur::class)->findAll();


        $messages = $this->getDoctrine()->getRepository(Messages::class)->getMessages($this->getUser()->getId(),$activeFriend->getId());

        return $this->render('chat/index.html.twig', [
            'users' => $users,
            'messages' => $messages,
            "activeFriend" => $activeFriend
        ]);
    }


    /**
     * @Route("/addMessage", name="chat_addMessage")
     */
    public function addMessage(Request $request)
    {
        //retrieve data from ajax request
        $type = $request->get("type");
        $friendId = $request->get("friendId");
        $message = $request->get("message");


        $em = $this->getDoctrine()->getManager();
        $friend = $em->getRepository(Utilisateur::class)->find($friendId);

        $msg = new Messages();
        $msg->setReceiver($friend);
        $msg->setSender($this->getUser());
        $msg->setCreated(new \DateTime('now'));
        $msg->setType($type);
        $msg->setSeen(0);
        $msg->setMessage($message);

        $em->persist($msg);
        $em->flush();

        return new JsonResponse("added");


    }

}
<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class PublicEventController extends AbstractController
{
    #[Route('/all/public/event', methods: "GET")]
    public function getAllPublicEvents(EventRepository $repository): Response
    {
        return $this->json([
            "content"=>"c'est les evenements public",
            "status"=>"200",
            "events"=>$repository->findBy(["privateStatus"=>false])
        ],200,[],["groups"=>"Event"]);

    }

    #[Route('/public/event/create',methods: "POST")]
    public function createPrivateEvent(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager):Response{

        $PublicEvent = $serializer->deserialize($request->getContent(),Event::class,"json");
        $PublicEvent->setPrivateStatus(false);
        $PublicEvent->setAuthor($this->getUser()->getProfile());
        $PublicEvent->addParticipant($this->getUser()->getProfile());

        $response = [
            "content"=>"tu a créer l'evenement ",
            "status"=>201,
            "new Event Infos"=>$PublicEvent
        ];

            $manager->persist($PublicEvent);
            $manager->flush();


        return $this->json($response,200,[],["groups"=>"Event"]);
    }

    #[Route('/public/event/getParticipants/{id}', methods: "GET")]
    public function getParticipantsPublicEvent(Event $event):Response{

        $participants = new ArrayCollection();
        foreach ($event->getParticipants() as $participant){
            $participants->add($participant);
        }

        $response = [
            "content"=>"les participants : ".$event->getId(),
            "status"=>200,
            "participants"=>$participants
        ];

        return $this->json($response,200,[],["groups"=>"User"]);
    }

}

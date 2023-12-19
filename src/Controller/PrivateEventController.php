<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Invitation;
use App\Entity\Profile;
use App\Entity\User;
use App\Repository\EventRepository;
use App\Repository\InvitationStatusRepository;
use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class PrivateEventController extends AbstractController
{
    //{
    // "place":"coucouuu",
    //  "description":"lala",
    //  "startof": "2023-12-20",
    //  "endof": "2023-12-21",
    //  "privateplace":"1",
    //   "participant": ["3"]
    //}
    #[Route('/create/private/event',methods: "POST")]
    public function createPrivateEvent(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager):Response{



        $PrivateEvent = $serializer->deserialize($request->getContent(),Event::class,"json");
        $PrivateEvent->setPrivateStatus(true);
        $PrivateEvent->setAuthor($this->getUser()->getProfile());
        $PrivateEvent->addParticipant($this->getUser()->getProfile());

        $response = [
            "content"=>"ta creer un evenements",
            "status"=>201,
            "Event Infos"=>$PrivateEvent
        ];

            $manager->persist($PrivateEvent);
            $manager->flush();



        return $this->json($response,200,[],["groups"=>"Event"]);
    }

    #[Route('/private/event/index/{id}', methods: "GET")]
    public function getAllPrivateEvents(User $user, ProfileRepository $profileRepository, EntityManagerInterface $manager, EventRepository $eventRepository): Response
    {
        $profile = $profileRepository->find($user->getProfile()->getId());
        $allPrivateEvents = $eventRepository->findBy(["privateStatus"=>true]);
        $events = new ArrayCollection();
        foreach ($allPrivateEvents as $privateEvent){
            foreach ($privateEvent->getParticipants() as $participant){
                if ($participant === $profile){
                    $events->add($privateEvent);
                }
            }
        }


        return $this->json($events,200,[],["groups"=>"Event"]);
    }

    #[Route('/private/event/invite/{id}/{userId}', methods: "POST")]
    public function inviteToPrivateEvent(Event $event,InvitationStatusRepository $statusRepository, EntityManagerInterface $manager, UserRepository $userRepository, $userId):Response{

        $searchProfile = $userRepository->find($userId)->getProfile();
        $actualProfile = $userRepository->find($this->getUser())->getProfile();

        if ($event->getAuthor() !== $actualProfile){
            $response = [
                "content"=>"tu es pas le proprio",
                "status"=>403
            ];
            return $this->json($response,403);
        }elseif ($event->getAuthor() === $searchProfile){

            return $this->json("",403);
        }

        foreach ($searchProfile->getInvitations() as $invitation){
            if ($invitation->getToEvent()->getAuthor() === $actualProfile){
                $response = [
                    "content"=>"deja invité",
                    "status"=>200
                ];
                return $this->json($response,200);
            }
        }


        $invitation = new Invitation();
        $invitation->setReceive($searchProfile);
        $invitation->setToEvent($event);
        $invitation->setStatus($statusRepository->find(1));

        $manager->persist($invitation);
        $manager->flush();

        $response = [
            "content"=>"c'est good tu la invité plus qu'a attendre sa réponse",
            "status"=>201,
            "invitation"=>$invitation
        ];

        return $this->json($response,201,[],["groups"=>"Invitation"]);
    }


    #[Route('/edit/private/event/{id}',methods: "PUT")]
    public function editPrivateEvent( Event $event, SerializerInterface $serializer, Request $request, EntityManagerInterface $manager):Response{

        $editPrivateEvent = $serializer->deserialize($request->getContent(),Event::class,"json",["object_to_populate"=>$event]);


        $response = [
            "content"=>"tu a changer ton evenement",
            "status"=>201,
            "Event Infos"=>$editPrivateEvent
        ];



        if ($editPrivateEvent->getEndOf() < $editPrivateEvent->getstartOf() ){
            $response = [
                "status"=>403,
            ];
        }elseif ($editPrivateEvent->getstartOf() < new \DateTime()){
            $response = [
                "status"=>403,
            ];
        }else{
            $manager->persist($editPrivateEvent);
            $manager->flush();
        }


        return $this->json($response,200,[],["groups"=>"Event"]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Contribution;
use App\Entity\Event;
use App\Entity\Suggestion;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class SuggestionController extends AbstractController
{
    #[Route('/add/suggestion/{eventId}',methods: "POST")]
    public function addSuggestion(#[MapEntity(id: 'eventId')] Event $event, EntityManagerInterface $manager,SerializerInterface $serializer, Request $request): Response
    {

        if ($event->getPrivateStatus()){
            return $this->json("l'evenement est privé",200);
        }
        if ($this->getUser()->getProfile() === $event->getAuthor()){


            $newSuggestion = $serializer->deserialize($request->getContent(),Suggestion::class,"json");
            $newSuggestion->setIsTaken(false);
            $newSuggestion->setEvent($event);

            $manager->persist($newSuggestion);
            $manager->flush();

            $response = [
                "content"=>"suggestion créer",
                "status"=>200,
                "suggestion"=>$newSuggestion
            ];
            return $this->json($response, 200, [],["groups"=>"forGroupIndexing"]);
        }


        return $this->json("tu ne peux pas", 200, );
    }

    #[Route('/accept/suggestion/{suggestionId}',methods: "POST")]
    public function acceptSuggestion(#[MapEntity(id: 'suggestionId')] Suggestion $suggestion, EntityManagerInterface $manager,SerializerInterface $serializer, Request $request): Response
    {
        if ($suggestion->getEvent()->getPrivateStatus()) {
            return $this->json("l'evenement est privé", 200);
        }

        foreach ($suggestion->getEvent()->getParticipants() as $participant) {
            if ($this->getUser()->getProfile() === $participant) {

                $contribution = new Contribution();

                $contribution->setSuggestion($suggestion);
                $contribution->setEvent($suggestion->getEvent());
                $contribution->setProduct($suggestion->getProduct());
                $contribution->setResponseProfile($this->getUser()->getProfile());

                $suggestion->setIsTaken(true);
                $suggestion->setOfContribution($contribution);
                $suggestion->setIssent($this->getUser()->getProfile());

                $manager->persist($contribution);
                $manager->persist($suggestion);
                $manager->flush();


                return $this->json("c'est good ", 200,);

            }

        }
        return $this->json("pas bon ca ", 201);

    }
}

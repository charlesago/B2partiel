<?php

namespace App\Controller;

use App\Entity\Contribution;
use App\Entity\Event;
use App\Entity\Suggestion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class ContributionController extends AbstractController
{
    #[Route('/create/contribution/{eventId}', methods: 'POST')]
    public function createContribution(#[MapEntity(id: 'eventId')] Event $event, EntityManagerInterface $manager, Request $request, SerializerInterface $serializer): Response
    {

        if (!$event->getPrivateStatus()) {
            return $this->json("impossible c'est un evenement public", 200);
        }

        foreach ($event->getParticipants() as $participant) {
            if ($this->getUser()->getProfile() === $participant) {

                $contribution = $serializer->deserialize($request->getContent(),Contribution::class,"json");
                $contribution->setResponseProfile($this->getUser()->getProfile());
                $contribution->setEvent($event);

                $manager->persist($contribution);
                $manager->flush();

                return $this->json("ta ajouter une contribution",201);
            }
        }


        return $this->json("tu fait pas partie du groupe", 200);
    }
}

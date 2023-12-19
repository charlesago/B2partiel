<?php

namespace App\Controller;

use App\Entity\Invitation;
use App\Entity\Profile;
use App\Entity\User;
use App\Repository\InvitationRepository;
use App\Repository\InvitationStatusRepository;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ProfileController extends AbstractController
{
    #[Route('/allprofiles', methods:['GET'])]
    public function index(ProfileRepository $repository): Response
    {
        return $this->json($repository->findAll(), 200,[], ['groups'=>'show_profiles']);
    }

    #[Route('/all/invitations',methods: "GET")]
    public function getAllInvitations(InvitationRepository $repository):Response{

        $myInvitations = [];
        $invitations = $repository->findAll();
        foreach ($invitations as $invitation)
        {
            if ($invitation->getReceive() == $this->getUser()->getProfile())
            {
                $myInvitations [] = $invitation;
            }
        }
        return $this->json($myInvitations, 200, [], ["groups"=>"Invitation"]);
    }
    #[Route('/invitations/accept/{id}', methods: "PUT")]
    public function acceptInvitation(Invitation $invitation, InvitationStatusRepository $repository, EntityManagerInterface $manager):Response{

        $response = [
            "content"=>"vous avez accepté l'invite",
            "status"=>200,
            "invitation"=>$invitation
        ];


        if ($invitation->getStatus()->getName() == "Accepted"){
            $response["content"] = "vous l'avez deja accepté!";
        }


        if ($invitation->getToEvent()->getstartof() < new \DateTime()){
            $response = [
                "content"=>"cette evenement n'est pas dispo",
                "status"=>200,
            ];
            $invitation->setStatus($repository->find(3));
        }else{
            $invitation->setStatus($repository->find(2));
        }

        $manager->persist($invitation);
        $manager->flush();
        return $this->json($response,200,[],["groups"=>"Invtation"]);
    }

}

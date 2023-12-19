<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $manager,UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        $user = $serializer->deserialize($request->getContent(), User::class, "json");

        $parameters = json_decode($request->getContent(), true);

        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $parameters["password"]
            )
        );

        $user->setProfile(new Profile());
        $user->getProfile()->setUsername($user->getUsername());


        $manager->persist($user);
        $manager->flush();

        $response = [
            "content"=> "The user ".$user->getProfile()->getUsername()." c'est créer",
            "status"=>201,
            "user"=>$user
        ];

        return $this->json($response, 201, [], ["groups" => "forUserIndexing"]);

    }
}
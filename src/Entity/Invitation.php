<?php

namespace App\Entity;

use App\Repository\InvitationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InvitationRepository::class)]
class Invitation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Invitation'])]

    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'invitations')]
    #[Groups(['Invitation'])]
    private ?Profile $receive = null;
    #[Groups(['Invitation'])]
    #[ORM\ManyToOne(inversedBy: 'invitations')]
    private ?Event $toEvent = null;

    #[ORM\ManyToOne(inversedBy: 'invitations')]
    private ?InvitationStatus $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceive(): ?Profile
    {
        return $this->receive;
    }

    public function setReceive(?Profile $receive): static
    {
        $this->receive = $receive;

        return $this;
    }

    public function getToEvent(): ?Event
    {
        return $this->toEvent;
    }

    public function setToEvent(?Event $toEvent): static
    {
        $this->toEvent = $toEvent;

        return $this;
    }

    public function getStatus(): ?InvitationStatus
    {
        return $this->status;
    }

    public function setStatus(?InvitationStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['show_profiles', 'User'])]
    private ?int $id = null;

    #[ORM\OneToOne( inversedBy: 'profile', cascade: ['persist', 'remove'])]
    private ?User $ofUser = null;

    #[ORM\Column(length: 255)]
    #[Groups(['show_profiles', 'User'])]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Event::class)]
    private Collection $events;

    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'participants')]
    private Collection $participantsEvent;

    #[ORM\OneToMany(mappedBy: 'receive', targetEntity: Invitation::class)]
    private Collection $invitations;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->participantsEvent = new ArrayCollection();
        $this->invitations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfUser(): ?User
    {
        return $this->ofUser;
    }

    public function setOfUser(?User $ofUser): static
    {
        $this->ofUser = $ofUser;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setAuthor($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getAuthor() === $this) {
                $event->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getParticipantsEvent(): Collection
    {
        return $this->participantsEvent;
    }

    public function addParticipantsEvent(Event $participantsEvent): static
    {
        if (!$this->participantsEvent->contains($participantsEvent)) {
            $this->participantsEvent->add($participantsEvent);
            $participantsEvent->addParticipant($this);
        }

        return $this;
    }

    public function removeParticipantsEvent(Event $participantsEvent): static
    {
        if ($this->participantsEvent->removeElement($participantsEvent)) {
            $participantsEvent->removeParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitation>
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): static
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations->add($invitation);
            $invitation->setReceive($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): static
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getReceive() === $this) {
                $invitation->setReceive(null);
            }
        }

        return $this;
    }
}

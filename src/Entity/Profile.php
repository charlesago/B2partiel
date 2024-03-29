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
    #[Groups(['show_profiles', 'User', 'Event', 'invitations','forGroupIndexing'])]
    private ?int $id = null;

    #[ORM\OneToOne( inversedBy: 'profile', cascade: ['persist', 'remove'])]
    private ?User $ofUser = null;

    #[ORM\Column(length: 255)]
    #[Groups(['show_profiles', 'User', 'Event', 'invitations','forGroupIndexing'])]
    private ?string $username = null;


    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Event::class)]

    private Collection $events;

    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'participants')]

    private Collection $participantsEvent;

    #[ORM\OneToMany(mappedBy: 'receive', targetEntity: Invitation::class)]

    private Collection $invitations;

    #[ORM\OneToMany(mappedBy: 'issent', targetEntity: Suggestion::class)]
    private Collection $suggestions;

    #[ORM\OneToMany(mappedBy: 'responseProfile', targetEntity: Contribution::class)]
    private Collection $contributions;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->participantsEvent = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->suggestions = new ArrayCollection();
        $this->contributions = new ArrayCollection();
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

    /**
     * @return Collection<int, Suggestion>
     */
    public function getSuggestions(): Collection
    {
        return $this->suggestions;
    }

    public function addSuggestion(Suggestion $suggestion): static
    {
        if (!$this->suggestions->contains($suggestion)) {
            $this->suggestions->add($suggestion);
            $suggestion->setIssent($this);
        }

        return $this;
    }

    public function removeSuggestion(Suggestion $suggestion): static
    {
        if ($this->suggestions->removeElement($suggestion)) {
            // set the owning side to null (unless already changed)
            if ($suggestion->getIssent() === $this) {
                $suggestion->setIssent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contribution>
     */
    public function getContributions(): Collection
    {
        return $this->contributions;
    }

    public function addContribution(Contribution $contribution): static
    {
        if (!$this->contributions->contains($contribution)) {
            $this->contributions->add($contribution);
            $contribution->setResponseProfile($this);
        }

        return $this;
    }

    public function removeContribution(Contribution $contribution): static
    {
        if ($this->contributions->removeElement($contribution)) {
            // set the owning side to null (unless already changed)
            if ($contribution->getResponseProfile() === $this) {
                $contribution->setResponseProfile(null);
            }
        }

        return $this;
    }
}

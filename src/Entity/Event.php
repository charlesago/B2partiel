<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['Event'])]
    private ?string $place = null;

    #[ORM\Column(length: 255)]
    #[Groups(['Event'])]

    private ?string $description = null;

    #[Groups(['Event'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startof = null;
    #[Groups(['Event'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endof = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[Groups(['Event'])]
    private ?Profile $author = null;


    #[Groups(['Event'])]
    #[ORM\Column]
    private ?bool $privateStatus = null;
    #[ORM\Column(length: 255)]
    #[Groups(['Event'])]
    private ?bool $privatePlace = null;

    #[ORM\ManyToMany(targetEntity: Profile::class, inversedBy: 'participantsEvent')]
    private Collection $participants;

    #[ORM\OneToMany(mappedBy: 'toEvent', targetEntity: Invitation::class)]
    private Collection $invitations;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Suggestion::class, orphanRemoval: true)]
    #[Groups(["forGroupIndexing"])]
    private Collection $suggestions;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Contribution::class)]
    private Collection $contributions;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->suggestions = new ArrayCollection();
        $this->contributions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartof(): \DateTimeInterface
    {
        return $this->startof;
    }

    public function setStartof(\DateTimeInterface $startof): static
    {
        $this->startof = $startof;

        return $this;
    }

    public function getEndof(): ?\DateTimeInterface
    {
        return $this->endof;
    }

    public function setEndof(\DateTimeInterface $endof): static
    {
        $this->endof = $endof;

        return $this;
    }

    public function getAuthor(): ?Profile
    {
        return $this->author;
    }

    public function setAuthor(?Profile $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPrivateStatus(): ?bool
    {
        return $this->privateStatus;
    }

    public function setPrivateStatus(bool $privatestatus): static
    {
        $this->privateStatus = $privatestatus;

        return $this;
    }

    public function getPrivateplace(): ?string
    {
        return $this->privatePlace;
    }

    public function setPrivateplace(string $privateplace): static
    {
        $this->privatePlace = $privateplace;

        return $this;
    }

    /**
     * @return Collection<int, Profile>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Profile $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(Profile $participant): static
    {
        $this->participants->removeElement($participant);

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
            $invitation->setToEvent($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): static
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getToEvent() === $this) {
                $invitation->setToEvent(null);
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
            $suggestion->setEvent($this);
        }

        return $this;
    }

    public function removeSuggestion(Suggestion $suggestion): static
    {
        if ($this->suggestions->removeElement($suggestion)) {
            // set the owning side to null (unless already changed)
            if ($suggestion->getEvent() === $this) {
                $suggestion->setEvent(null);
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
            $contribution->setEvent($this);
        }

        return $this;
    }

    public function removeContribution(Contribution $contribution): static
    {
        if ($this->contributions->removeElement($contribution)) {
            // set the owning side to null (unless already changed)
            if ($contribution->getEvent() === $this) {
                $contribution->setEvent(null);
            }
        }

        return $this;
    }
}

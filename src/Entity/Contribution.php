<?php

namespace App\Entity;

use App\Repository\ContributionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContributionRepository::class)]
class Contribution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $product = null;

    #[ORM\ManyToOne(inversedBy: 'contributions')]
    private ?Profile $responseProfile = null;

    #[ORM\ManyToOne(inversedBy: 'contributions')]
    private ?Event $event = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Suggestion $suggestion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getResponseProfile(): ?Profile
    {
        return $this->responseProfile;
    }

    public function setResponseProfile(?Profile $responseProfile): static
    {
        $this->responseProfile = $responseProfile;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getSuggestion(): ?Suggestion
    {
        return $this->suggestion;
    }

    public function setSuggestion(?Suggestion $suggestion): static
    {
        $this->suggestion = $suggestion;

        return $this;
    }
}

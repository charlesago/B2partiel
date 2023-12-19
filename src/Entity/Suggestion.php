<?php

namespace App\Entity;

use App\Repository\SuggestionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SuggestionRepository::class)]
class Suggestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["forGroupIndexing"])]
    private ?string $product = null;

    #[ORM\ManyToOne(inversedBy: 'suggestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'suggestions')]
    #[Groups(["forGroupIndexing"])]
    private ?Profile $issent = null;

    #[ORM\Column]
    #[Groups(["forGroupIndexing"])]
    private ?bool $isTaken = null;

    #[ORM\OneToOne(inversedBy: 'suggestion', cascade: ['persist', 'remove'])]
    private ?Contribution $ofContribution = null;
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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getIssent(): ?Profile
    {
        return $this->issent;
    }

    public function setIssent(?Profile $issent): static
    {
        $this->issent = $issent;

        return $this;
    }

    public function isIsTaken(): ?bool
    {
        return $this->isTaken;
    }

    public function setIsTaken(bool $isTaken): static
    {
        $this->isTaken = $isTaken;

        return $this;
    }

    public function getOfContribution(): ?Contribution
    {
        return $this->ofContribution;
    }

    public function setOfContribution(?Contribution $ofContribution): void
    {
        $this->ofContribution = $ofContribution;
    }


}

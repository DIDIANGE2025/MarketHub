<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $buyer = null;

    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order = null;

    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getBuyer(): ?User { return $this->buyer; }
    public function setBuyer(?User $buyer): self { $this->buyer = $buyer; return $this; }
    public function getService(): ?Service { return $this->service; }
    public function setService(?Service $service): self { $this->service = $service; return $this; }
    public function getOrder(): ?Order { return $this->order; }
    public function setOrder(?Order $order): self { $this->order = $order; return $this; }
    public function getRating(): ?int { return $this->rating; }
    public function setRating(int $rating): self { $this->rating = $rating; return $this; }
    public function getComment(): ?string { return $this->comment; }
    public function setComment(?string $comment): self { $this->comment = $comment; return $this; }
    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
}
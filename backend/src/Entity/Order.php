<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
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

    #[ORM\Column(length: 20, options: ['default' => 'pending'])]
    private ?string $status = 'pending';

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $total = null;

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
    public function getStatus(): ?string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function getTotal(): ?string { return $this->total; }
    public function setTotal(string $total): self { $this->total = $total; return $this; }
    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
}
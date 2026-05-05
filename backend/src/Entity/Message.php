<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $sender = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $receiver = null;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Order $order = null;

    #[ORM\Column(type: 'text')]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $sentAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $readAt = null;

    public function __construct()
    {
        $this->sentAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getSender(): ?User { return $this->sender; }
    public function setSender(?User $sender): self { $this->sender = $sender; return $this; }
    public function getReceiver(): ?User { return $this->receiver; }
    public function setReceiver(?User $receiver): self { $this->receiver = $receiver; return $this; }
    public function getOrder(): ?Order { return $this->order; }
    public function setOrder(?Order $order): self { $this->order = $order; return $this; }
    public function getContent(): ?string { return $this->content; }
    public function setContent(string $content): self { $this->content = $content; return $this; }
    public function getSentAt(): ?\DateTimeImmutable { return $this->sentAt; }
    public function getReadAt(): ?\DateTimeImmutable { return $this->readAt; }
    public function setReadAt(?\DateTimeImmutable $readAt): self { $this->readAt = $readAt; return $this; }
}
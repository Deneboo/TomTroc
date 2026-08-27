<?php

namespace App\Models;

class Message
{
    private ?int $id = null;
    private string $message;
    private User $sender;
    private User $receiver;
    private \DateTime $createdAt;
    private ?int $bookId = null;

    public function __construct(
        int $id,
        string $message,
        User $sender,
        User $receiver,
        \DateTime $createdAt,
        ?int $bookId = null,
    ) {
        $this->id = $id;
        $this->message = $message;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->createdAt = $createdAt;
        $this->bookId = $bookId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getSender(): User
    {
        return $this->sender;
    }

    public function setSenderId(User $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function getReceiver(): User
    {
        return $this->receiver;
    }

    public function setReceiverId(User $receiver): self
    {
        $this->receiver = $receiver;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    public function setBookId(?int $bookId): self
    {
        $this->bookId = $bookId;
        return $this;
    }
}

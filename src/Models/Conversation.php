<?php

namespace App\Models;

class Conversation
{
    private ?int $id = null;
    private int $user1Id;
    private int $user2Id;
    private \DateTime $createdAt;

    public function __construct(
        int $id,
        int $user1Id,
        int $user2Id,
        \DateTime $createdAt,
    ) {
        $this->id = $id;
        $this->user1Id = $user1Id;
        $this->user2Id = $user2Id;
        $this->createdAt = $createdAt;
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

    public function getUser1Id(): int
    {
        return $this->user1Id;
    }

    public function setUser1Id(int $user1Id): self
    {
        $this->user1Id = $user1Id;
        return $this;
    }

    public function getUser2Id(): int
    {
        return $this->user2Id;
    }

    public function setUser2Id(int $user2Id): self
    {
        $this->user2Id = $user2Id;
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
}

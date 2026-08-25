<?php

namespace App\Models;

class Book
{
    private int $id;
    private string $title;
    private string $author;
    private string $description;
    private \DateTime $createdAt;
    private User $user;
    private bool $isAvailable;
    private ?string $image;

    public function __construct(int $id, string $title, string $author, string $description, \DateTime $createdAt, User $user, bool $isAvailable = true, ?string $image = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->user = $user;
        $this->isAvailable = $isAvailable;
        $this->image = $image;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Getter pour le titre.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Setter pour le titre.
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter pour le author.
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Setter pour le titre.
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * Getter for image.
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Setter for image.
     * @param string $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * Getter for description.
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Setter for description.
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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

    /**
    * Getter for user.
    * @return User
    */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Setter for user.
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Getter for isAvailable.
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }

    /**
     * Setter for isAvailable.
     */
    public function setIsAvailable(bool $isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }
}

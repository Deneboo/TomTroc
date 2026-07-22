<?php

namespace App\Models;

class Book
{
    private int $id;
    private string $title;
    private string $author;
    private string $description;
    private string $image;
    private string $userId;

    public function __construct(int $id, string $title, string $author, string $description, string $image, string $userId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->description = $description;
        $this->image = $image;
        $this->userId = $userId;
    }

    public function getId(): int
    {
        return $this->id;
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
    public function getImage(): string
    {
        return $this->author;
    }

    /**
     * Setter for image.
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    //  /**
    //  * Getter for userId.
    //  * @return string
    //  */
    // public function getUserId(): string
    // {
    //     $user = User::getUserId();

    // return $user->getUsername();
    // }

    // /**
    //  * Setter for userId.
    //  * @param string $userId
    //  */
    // public function setUserId(string $userId): void
    // {
    //     $this->userId = $userId;
    // }

}

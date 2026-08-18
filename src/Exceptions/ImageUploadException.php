<?php

namespace App\Exceptions;

class ImageUploadException extends \Exception
{
    public const FILE_TOO_LARGE = 1;
    public const INVALID_MIME_TYPE = 2;
    public const UPLOAD_FAILED = 3;

    public function getErrorMessage(): string
    {
        // code returned with \Exception
        return match ($this->code) {
            self::FILE_TOO_LARGE => $this->message,
            self::INVALID_MIME_TYPE =>
                "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.",
            self::UPLOAD_FAILED =>
                "Une erreur s'est produite lors du téléchargement du fichier.",
            default =>
                "Une erreur s'est produite lors du téléchargement de l'image.",
        };
    }
}
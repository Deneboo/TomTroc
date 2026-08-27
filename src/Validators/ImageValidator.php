<?php

namespace App\Validators;

require_once(__DIR__ . '/../../config/config.php');

use App\Exceptions\ImageUploadException;

class ImageValidator
{
    public function validateSize(array $file, string $imageType): void
    {
        $limit = IMAGE_MAX_SIZES[$imageType];
        $limitKo = round($limit / 1024);
        $errorMessage
            = "Votre fichier est trop volumineux. "
            . "La taille maximale autorisée est de "
            . $limitKo
            . " Ko.";
        if ($file['size'] > $limit) {
            throw new ImageUploadException(
                $errorMessage,
                ImageUploadException::FILE_TOO_LARGE,
            );
        }
    }

    public function validateMimeType(array $file): void
    {
        $check = getimagesize($file['tmp_name']);

        if (
            $check === false
            || !in_array($check['mime'], ['image/jpeg', 'image/png', 'image/gif'])
        ) {
            throw new ImageUploadException(
                code: ImageUploadException::INVALID_MIME_TYPE,
            );
        }
    }

    public function validate(array $file, string $imageType): void
    {
        $this->validateSize($file, $imageType);
        $this->validateMimeType($file);
    }
}

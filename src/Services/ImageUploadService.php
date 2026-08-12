<?php

namespace App\Services;

class ImageUploadService
{
        public function uploadImage(
            string $imageType,
            int $userId,
        ): string 
        {

        $targetDir = __DIR__
            . '/../../public/assets/uploads/'
            . $userId
            . '/'
            . $imageType
            . '/';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $file = $_FILES['fileToUpload'];
        $extension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );
        $fileName = uniqid('', true) . '.' . $extension;
        $targetFile = $targetDir . $fileName;

        if (!move_uploaded_file(
            $_FILES['fileToUpload']['tmp_name'],
            $targetFile,
        )) {
            throw new \RuntimeException(
                "Une erreur s'est produite lors du téléchargement du fichier."
            );
        }

        return '/assets/uploads/'
            . $userId
            . '/'
            . $imageType
            . '/'
            . $fileName;
    }
}

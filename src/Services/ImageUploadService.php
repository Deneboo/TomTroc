<?php

namespace App\Services;

class ImageUploadService
{
    public function uploadImage(
        string $imageType,
        int $userId,
    ): array {
        $errorFile = null;

        switch ($imageType) {
            case 'book_cover':
                $limit = 5000000;
                $imageLabel = 'couverture de livre';
                break;

            case 'avatar':
                $limit = 200000;
                $imageLabel = 'avatar';
                break;

            default:
                $limit = 200000;
                $imageLabel = 'image';
                break;
        }

        $targetDir = __DIR__
            . '/../../public/assets/uploads/'
            . $userId
            . '/'
            . $imageType
            . '/';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($_FILES['fileToUpload']['name']);
        $targetFile = $targetDir . $fileName;

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['fileToUpload']['tmp_name']);

        if ($check === false) {
            $errorFile = "Le fichier n'est pas une image valide.";
            $uploadOk = 0;
        }

        if (file_exists($targetFile)) {
            $errorFile = "Le fichier existe déjà.";
            $uploadOk = 0;
        }

        if ($_FILES['fileToUpload']['size'] > $limit) {
            $limitKo = round($limit / 1024);

            $errorFile
                = "Votre fichier est trop volumineux. "
                . "La taille maximale autorisée est de "
                . $limitKo
                . " Ko.";

            $uploadOk = 0;
        }

        if (
            $imageFileType !== 'jpg'
            && $imageFileType !== 'jpeg'
            && $imageFileType !== 'png'
            && $imageFileType !== 'gif'
        ) {
            $errorFile
                = 'Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.';

            $uploadOk = 0;
        }

        if ($uploadOk === 0) {
            return [
                'success' => false,
                'path' => null,
                'message' => null,
                'error' => $errorFile,
            ];
        }

        if (!move_uploaded_file(
            $_FILES['fileToUpload']['tmp_name'],
            $targetFile,
        )) {
            return [
                'success' => false,
                'path' => null,
                'message' => null,
                'error' => "Une erreur s'est produite lors du téléchargement du fichier.",
            ];
        }

        $filePath
            = '/assets/uploads/'
            . $userId
            . '/'
            . $imageType
            . '/'
            . $fileName;

        return [
            'success' => true,
            'path' => $filePath,
            'message' => 'Votre ' . $imageLabel . ' a été mis à jour avec succès.',
            'error' => null,
        ];
    }
}

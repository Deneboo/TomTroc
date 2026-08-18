<?php

namespace App\Services;

use App\Exceptions\ImageUploadException;
class ImageUploadService
{
        public function uploadImage(
            string $imageType,
            int $userId,
            ?int $bookId = null
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
        $fileName = $imageType === 'book_cover' ? $bookId . '_' . $imageType . '.' . $extension : $imageType . '.' . $extension;
        $targetFile = $targetDir . $fileName;

        if (!move_uploaded_file(
            $_FILES['fileToUpload']['tmp_name'],
            $targetFile,
        )) {
            throw new ImageUploadException(
                code: ImageUploadException::UPLOAD_FAILED
            );
        }

        $filePath = '/assets/uploads/'
            . $userId
            . '/'
            . $imageType
            . '/'
            . $fileName;

        return $filePath;
    }
}

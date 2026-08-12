<?php

Namespace App\Validators;

require_once(__DIR__ . '/../../config/config.php');

class ImageValidator 
{

  public function validateSize(array $file, string $imageType): ?string
  {
      $limit = IMAGE_MAX_SIZES[$imageType];
      $limitKo = round($limit / 1024);
      $errorMessage
                = "Votre fichier est trop volumineux. "
                . "La taille maximale autorisée est de "
                . $limitKo
                . " Ko.";
      if ($file['size'] > $limit) {
          return $errorMessage;
      }
      return null;
  }

  public function validateMimeType(array $file): ?string
  {
    $check = getimagesize($file['tmp_name']);
        if (
            $check === false
            || !in_array($check['mime'], ['image/jpeg', 'image/png', 'image/gif'])
        ) 
        {
            return "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        }
      return null;
  }

  public function validate(array $file, string $imageType): ?string
  {
      $error = $this->validateSize($file, $imageType);

      if ($error !== null) {
          return $error;
      }

      $error = $this->validateMimeType($file);

      if ($error !== null) {
          return $error;
      }

      return null;
    }
}
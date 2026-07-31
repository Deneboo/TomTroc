<?php

namespace App\Services;

class Validator
{
    private array $errors = [];

    public function required(string $field, mixed $value): void
    {
        if (empty($value)) {
            $this->errors[$field] = "Le champ {$field} est obligatoire.";
        }
    }

    public function email(string $field, string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "L'adresse email est invalide.";
        }
    }

    public function minLength(string $field, string $value, int $min): void
    {
        if (strlen($value) < $min) {
            $this->errors[$field] = "Le champ {$field} doit contenir au moins {$min} caractères.";
        }
    }

    public function maxLength(string $field, string $value, int $min): void
    {
        if (strlen($value) > $min) {
            $this->errors[$field] = "Le champ {$field} ne doit faire plus de {$max} caractères.";
        }
    }

    public function integer(string $field, mixed $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $this->errors[$field] = "Le champ {$field} doit être un entier.";
        }
    }

    public function string(string $field, mixed $value): void
    {
        if (!is_string($value)) {
            $this->errors[$field] = "Le champ {$field} doit être une chaîne de caractères.";
        }
    }

    public function password(string $field, string $value): void
    {
        if (
            strlen($value) < 8 ||
            !preg_match('/[A-Z]/', $value) ||
            !preg_match('/[a-z]/', $value) ||
            !preg_match('/[0-9]/', $value) ||
            !preg_match('/[\W]/', $value)
        ) {
            $this->errors[$field] = 
                "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
        }
    }

    // Comfirm entry (password or email ie.)
    public function confirmed(string $field, string $value, string $confirmation): void
    {
        if ($value !== $confirmation) {
            $this->errors[$field] = "La confirmation ne correspond pas.";
        }
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }
}
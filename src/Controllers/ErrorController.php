<?php

namespace App\Controllers;

use App\Views\View;

class ErrorController
{
    public function error404(string $errorMessage): void
    {

        http_response_code(404);
        View::render('Templates/Site/errorPage', [
            'errorMessage' => $errorMessage,
        ]);
    }

    public function error500(): void
    {
        http_response_code(500);
        $errorMessage = " 500 - Erreur interne du serveur.";
        View::render('Templates/Site/errorPage', [
            'errorMessage' => $errorMessage,
        ]);
    }
}

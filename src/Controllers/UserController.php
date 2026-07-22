<?php

namespace App\Controllers;

use App\Views\View;

class UserController
{
    public function loginPage(): void
    {
        View::render('Templates/Site/login');
    }

    public function registerPage(): void
    {
        View::render('Templates/Site/register');
    }
}

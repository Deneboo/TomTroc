<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Views\View;
use App\Repository\BookRepository;

class HomeController
{
    private BookRepository $bookRepository;

    public function __construct(DBConnect $database)
    {
        $this->bookRepository = new BookRepository($database->getConnection());
    }

    public function index(): void
    {
        $books = $this->bookRepository->findFourLatest();
        View::render('Templates/Site/home', [
            'books' => $books
        ]);
    }
}

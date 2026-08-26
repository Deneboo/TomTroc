<?php

namespace App\Database\Fixtures;

class BookFixtures
{
    public static function getData(): array
    {
        return [
            [
                'title' => 'Alabaster 2',
                'author' => 'Esther Mango',
                'description' => 'Un roman captivant.',
                'image' => '/assets/images/fixtures/books/alabaster.jpg',
                'seller' => 'CamilleClubLit',
                'is_available' => true,
            ],
            [
                'title' => 'The Kinfolk Table',
                'author' => 'Nathan Williams',
                'description' => 'Recettes et art de vivre.',
                'image' => '/assets/images/fixtures/books/frosty-ilze.jpg',
                'seller' => 'Nathalire',
                'is_available' => true,
            ],
            [
                'title' => 'Wabi Sabi',
                'author' => 'Beth Kempton',
                'description' => 'Découvrir la philosophie japonaise du Wabi Sabi.',
                'image' => '/assets/images/fixtures/books/anni-sprat.jpg',
                'seller' => 'Alexlecture',
                'is_available' => true,
            ],
            [
                'title' => 'Milk & Honey',
                'author' => 'Rupi Kaur',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/fixtures/books/sincerely-media.jpg',
                'seller' => 'Hugo1990_12',
                'is_available' => true,
            ],
            [
                'title' => 'Delight!',
                'author' => 'Justin Rossow',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/fixtures/books/delight.jpg',
                'seller' => 'Hugo1990_12',
                'is_available' => true,
            ],
            [
                'title' => 'Milwaukee Mission',
                'author' => 'Elder Cooper Low',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/fixtures/books/milwaukee-mission.jpg',
                'seller' => 'Hugo1990_12',
                'is_available' => true,
            ],
            [
                'title' => 'Minimalist Graphics',
                'author' => 'Julia Schonlau',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/fixtures/books/minimalist-graphics.jpg',
                'seller' => 'Hugo1990_12',
                'is_available' => true,
            ],
            [
                'title' => 'Hygge',
                'author' => 'Meik Wiking',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/fixtures/books/hygge.jpg',
                'seller' => 'Hugo1990_12',
                'is_available' => true,
            ],
            [
                'title' => 'Innovation',
                'author' => 'Matt Ridley',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/fixtures/books/innovation.jpg',
                'seller' => 'Hugo1990_12',
                'is_available' => true,
            ],
            [
                'title' => 'Psalms',
                'author' => 'Alabaster',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/fixtures/books/psalms.jpg',
                'seller' => 'Hugo1990_12',
                'is_available' => true,
            ],
        ];
    }
}

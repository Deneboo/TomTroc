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
                'image' => '/assets/images/alabaster.jpg',
                'seller' => 'CamilleClubLit',
            ],
            [
                'title' => 'The Kinfolk Table',
                'author' => 'Nathan Williams',
                'description' => 'Recettes et art de vivre.',
                'image' => '/assets/images/frosty-ilze.jpg',
                'seller' => 'Nathalire',
            ],
            [
                'title' => 'Wabi Sabi',
                'author' => 'Beth Kempton',
                'description' => 'Découvrir la philosophie japonaise du Wabi Sabi.',
                'image' => '/assets/images/anni-sprat.jpg',
                'seller' => 'Alexlecture',
            ],
            [
                'title' => 'Milk & Honey',
                'author' => 'Rupi Kaur',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/sincerely-media.jpg',
                'seller' => 'Hugo1990_12',
            ],
            [
                'title' => 'Delight!',
                'author' => 'Justin Rossow',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/delight.jpg',
                'seller' => 'Hugo1990_12',
            ],
            [
                'title' => 'Milwaukee Mission',
                'author' => 'Elder Cooper Low',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/milwaukee-mission.jpg',
                'seller' => 'Hugo1990_12',
            ],
            [
                'title' => 'Minimalist Graphics',
                'author' => 'Julia Schonlau',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/minimalist-graphics.jpg',
                'seller' => 'Hugo1990_12',
            ],
            [
                'title' => 'Hygge',
                'author' => 'Meik Wiking',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/hygge.jpg',
                'seller' => 'Hugo1990_12',
            ],
            [
                'title' => 'Innovation',
                'author' => 'Matt Ridley',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/innovation.jpg',
                'seller' => 'Hugo1990_12',
            ],
            [
                'title' => 'Psalms',
                'author' => 'Alabaster',
                'description' => 'Recueil de poésie contemporaine.',
                'image' => '/assets/images/psalms.jpg',
                'seller' => 'Hugo1990_12',
            ],
        ];
    }
}

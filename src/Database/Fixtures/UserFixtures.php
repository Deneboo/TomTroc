<?php

namespace App\Database\Fixtures;

class UserFixtures
{
    public static function getData(): array
    {
        return [
            [
                'email' => 'camille@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'CamilleClubLit',
                'avatar' => '/assets/images/fixtures/users/camille.jpg',
            ],
            [
                'email' => 'nathalie@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'Nathalire',
                'avatar' => '/assets/images/fixtures/users/nathalire.jpg',
            ],
            [
                'email' => 'alex@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'Alexlecture',
                'avatar' => '/assets/images/fixtures/users/alex-lecture.jpg',
            ],
            [
                'email' => 'hugo@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'Hugo1990_12',
                'avatar' => '/assets/images/fixtures/users/hugo.jpg',
            ],
        ];
    }
}

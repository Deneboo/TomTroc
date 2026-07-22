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
                'avatar' => null,
            ],
            [
                'email' => 'nathalie@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'Nathalire',
                'avatar' => null,
            ],
            [
                'email' => 'alex@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'Alexlecture',
                'avatar' => null,
            ],
            [
                'email' => 'hugo@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'Hugo1990_12',
                'avatar' => null,
            ],
        ];
    }
}

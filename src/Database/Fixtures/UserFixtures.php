<?php

namespace App\Database\Fixtures;

class UserFixtures
{
    public static function getData(): array
    {
        return [
            [
                'email' => 'nathalie@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'Nathalire',
                'avatar' => '/assets/images/fixtures/users/nathalire.jpg',
                'created_at' => '2025-11-02 18:45:00',
            ],
            [
                'email' => 'camille@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'CamilleClubLit',
                'avatar' => '/assets/images/fixtures/users/camille.jpg',
                'created_at' => '2026-03-15 10:30:00',
            ],
            [
                'email' => 'alex@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'Alexlecture',
                'avatar' => '/assets/images/fixtures/users/alex-lecture.jpg',
                'created_at' => '2026-07-07 12:52:03',
            ],
            [
                'email' => 'hugo@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'username' => 'Hugo1990_12',
                'avatar' => '/assets/images/fixtures/users/hugo.jpg',
                'created_at' => '2026-08-08 12:52:03',
            ],
        ];
    }
}

<?php

namespace App\Views;

class View
{
    public static function render(string $view, array $data = [])
    {
        extract($data);

        ob_start();
        require __DIR__ . '/' . $view . '.php';
        $content = ob_get_clean();

        require __DIR__ . '/Templates/Layouts/main.php';
    }
}

<?php

namespace App\Views;

class View
{
    public static function render(string $view, array $data = [])
    {
        extract($data);

        ob_start();
        // var_dump($view);
        require __DIR__ . '/' . $view . '.php';
        $content = ob_get_clean();
        // var_dump($content);

        require __DIR__ . '/Templates/Layouts/main.php';
    }
}

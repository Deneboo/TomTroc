<?php

namespace App\Utils;

class TextFormat {
    public static function pluralize(int $count, string $word): string
    {
        return $count <= 1
            ? $word
            : ($word . 's');
    }
}
    
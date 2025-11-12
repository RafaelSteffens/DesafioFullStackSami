<?php

namespace App\Support\Formatters;

class CpfFormatter
{
    public static function format(?string $cpf): ?string
    {
        if ($cpf === null) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $cpf);

        if (strlen($digits) !== 11) {
            return $cpf;
        }

        return vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($digits));
    }
}

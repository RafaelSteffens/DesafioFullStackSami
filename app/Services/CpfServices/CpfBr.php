<?php

namespace App\Services\CpfServices;

use Illuminate\Contracts\Validation\Rule;

class CpfBr implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        $cpf = preg_replace('/\D/', '', (string) $value);

        if (strlen($cpf) !== 11) {
            return false;
        }

        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        $digits = array_map('intval', str_split($cpf));

        $firstCheck = $this->calculateDigit($digits, 9);
        $secondCheck = $this->calculateDigit($digits, 10);

        return $digits[9] === $firstCheck && $digits[10] === $secondCheck;
    }

    public function message(): string
    {
        return 'O :attribute informado é inválido.';
    }

    /**
     * @param array<int, int> $digits
     */
    private function calculateDigit(array $digits, int $length): int
    {
        $sum = 0;

        for ($i = 0; $i < $length; $i++) {
            $sum += $digits[$i] * (($length + 1) - $i);
        }

        $result = ($sum * 10) % 11;

        return $result === 10 ? 0 : $result;
    }
}

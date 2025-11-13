<?php

namespace App\Http\Requests;

use App\Services\CpfServices\CpfBr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', new CpfBr(), Rule::unique('people', 'cpf')],
            'data_nascimento' => ['required', 'date', 'before:today'],
            'email' => ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255', Rule::unique('people', 'email')],
            'telefone' => ['required', 'string', 'regex:/^[0-9+\-\s()]{10,20}$/'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nome' => is_string($this->input('nome')) ? trim((string) $this->input('nome')) : $this->input('nome'),
            'cpf' => preg_replace('/\D/', '', (string) $this->input('cpf')),
            'data_nascimento' => $this->input('data_nascimento'),
            'email' => is_string($this->input('email')) ? mb_strtolower(trim((string) $this->input('email'))) : $this->input('email'),
            'telefone' => preg_replace('/\s+/', '', (string) $this->input('telefone')),
        ]);
    }

    public function attributes(): array
    {
        return [
            'nome' => 'nome',
            'cpf' => 'CPF',
            'data_nascimento' => 'data de nascimento',
            'email' => 'e-mail',
            'telefone' => 'telefone',
        ];
    }
}

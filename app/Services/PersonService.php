<?php

namespace App\Services;

use App\Models\Person;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PersonService
{
    /**
     * Lista paginada com filtro opcional.
     */
    public function paginate(?string $query = null, int $perPage = 10): LengthAwarePaginator
    {
        $term = trim((string) $query);

        return Person::query()
            ->when($term !== '', function ($builder) use ($term): void {
                $builder->where(function ($inner) use ($term): void {
                    $inner
                        ->where('nome', 'like', '%' . $term . '%')
                        ->orWhere('email', 'like', '%' . $term . '%')
                        ->orWhere('cpf', 'like', '%' . preg_replace('/\D/', '', $term) . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Cria uma pessoa normalizando os dados.
     * @param array<string,mixed> $data
     */
    public function create(array $data): Person
    {
        $normalized = $this->normalizeData($data);
        return Person::create($normalized);
    }

    /**
     * Atualiza e retorna o model atualizado.
     * @param array<string,mixed> $data
     */
    public function update(Person $person, array $data): Person
    {
        $normalized = $this->normalizeData($data);
        $person->update($normalized);
        return $person->refresh();
    }

    /**
     * Exclui o registro.
     */
    public function delete(Person $person): void
    {
        $person->delete();
    }

    /**
     * Normaliza campos antes de persistir.
     * @param array<string,mixed> $data
     * @return array<string,mixed>
     */
    private function normalizeData(array $data): array
    {
        return [
            'nome'             => trim((string) ($data['nome'] ?? '')),
            'cpf'              => preg_replace('/\D/', '', (string) ($data['cpf'] ?? '')),
            // aqui assumimos que já vem em Y-m-d do componente; se vier vazio, salva null
            'data_nascimento'  => ($data['data_nascimento'] ?? '') !== '' ? (string) $data['data_nascimento'] : null,
            'email'            => mb_strtolower(trim((string) ($data['email'] ?? ''))),
            // mantém só + e dígitos; remove espaços e símbolos
            'telefone'         => preg_replace('/(?!^\+)\D+/', '', (string) ($data['telefone'] ?? '')),
        ];
    }
}

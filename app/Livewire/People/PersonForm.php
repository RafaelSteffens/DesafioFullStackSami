<?php

namespace App\Livewire\People;

use App\Models\Person;
use App\Services\CpfServices\CpfFormatter;
use App\Services\PersonService;
use App\Services\CpfServices\CpfBr;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Throwable;

#[Layout('layouts.app')]
class PersonForm extends Component
{
    public ?Person $person = null;

    public array $form = [
        'nome' => '',
        'cpf' => '',
        'data_nascimento' => '',
        'email' => '',
        'telefone' => '',
    ];

    public function mount(): void
    {
        $personId = request()->route('personId');

        if ($personId) {
            $this->person = Person::find($personId);

            if ($this->person) {
                $this->form = [
                    'nome'            => $this->person->nome ?? '',
                    'cpf'             => CpfFormatter::format($this->person->cpf) ?? $this->person->cpf,
                    'data_nascimento' => optional($this->person->data_nascimento)->format('Y-m-d'),
                    'email'           => $this->person->email ?? '',
                    'telefone'        => $this->person->telefone ?? '',
                ];
            }
        }
    }

    protected function rules(): array
    {
        $personId = $this->person?->id;

        return [
            'form.nome' => ['required', 'string', 'max:255'],
            'form.cpf' => [
                'required',
                'string',
                new CpfBr(),
                function (string $attribute, mixed $value, \Closure $fail) use ($personId) {
                    $cpfNumero = preg_replace('/\D/', '', (string) $value);

                    $jaExiste = Person::query()
                        ->where('cpf', $cpfNumero)
                        ->when($personId, fn ($q) => $q->where('id', '!=', $personId))
                        ->exists();

                    if ($jaExiste) {
                        $fail('Este CPF já está cadastrado.');
                    }
                },
            ],
            'form.data_nascimento' => ['required', 'date', 'before:today'],
            'form.email' => [
                'required',
                'string',
                'lowercase',
                'email:rfc,dns',
                'max:255',
                Rule::unique('people', 'email')->ignore($personId),
            ],
            'form.telefone' => ['required', 'string', 'regex:/^[0-9+\-\s()]{10,20}$/'],
        ];
    }

    public function save(PersonService $personService)
    {
        $this->validate();

        try {
            if ($this->person) {
                $personService->update($this->person, $this->form);
            } else {
                $this->person = $personService->create($this->form);
            }

            session()->flash('status', 'Pessoa salva com sucesso.');

            return redirect()->route('people.index');
        } catch (Throwable $e) {
            Log::error('Erro ao salvar pessoa', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            $this->dispatch('form-error', 'Ocorreu um erro ao salvar a pessoa. Tente novamente.');
        }
    }

    public function render()
    {
        return view('livewire.people.personform');
    }
}

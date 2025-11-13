<?php
namespace App\Livewire\People;

use App\Http\Controllers\Api\PersonController;
use App\Models\Person;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Support\Formatters\CpfFormatter;
use App\Services\PersonService;
use App\Rules\CpfBr;
use Illuminate\Validation\Rule;

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

                // regra de unicidade customizada
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

    public function save(PersonController $personController)
    {
        $this->validate(); 

        try {
            if ($this->person) {
                $personController->updateFromArray($this->person, $this->form);
            } else {
                $this->person = $personController->storeFromArray($this->form);
            }

            return redirect()->route('people.index');

        } catch (Throwable $e) {
            Log::error('Erro ao salvar pessoa: ' . $e->getMessage());

            $this->dispatch('form-error', $e->getMessage());
            return;
        }
    }

        

    public function render()
    {
        return view('livewire.people.personform');
    }
}

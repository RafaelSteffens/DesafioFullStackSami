<?php
namespace App\Livewire\People;

use App\Models\Person;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        $personId = request()->route('person');

        if ($personId) {
            $this->person = Person::find($personId);

            if ($this->person) {
                $this->form = [
                    'nome'            => $this->person->nome ?? '',
                    'cpf'             => $this->person->cpf ?? '',
                    'data_nascimento' => optional($this->person->data_nascimento)?->format('Y-m-d') ?? '',
                    'email'           => $this->person->email ?? '',
                    'telefone'        => $this->person->telefone ?? '',
                ];
            }
        }
    }

    // teste: cria sem validação e sem service
    // app/Livewire/People/PersonForm.php
    public function create()
    {
        $payload = $this->form;

        // 🔧 normalizações mínimas pra não quebrar
        $payload['cpf'] = preg_replace('/\D+/', '', $payload['cpf'] ?? '');        // só dígitos
        $payload['telefone'] = preg_replace('/(?!^\+)\D+/', '', $payload['telefone'] ?? '');
        if (!empty($payload['data_nascimento'])) {
            $payload['data_nascimento'] = \Carbon\Carbon::parse($payload['data_nascimento'])->format('Y-m-d');
        }

        Person::create($payload);
        session()->flash('status', 'Criado (sem validação).');
        $this->reset('form');

        return redirect()->route('people.index');
    }

    public function render()
    {
        return view('livewire.people.personform');
    }
}

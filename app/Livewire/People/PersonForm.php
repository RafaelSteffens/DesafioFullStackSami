<?php
namespace App\Livewire\People;

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
            'form.cpf' => ['required', 'string', new CpfBr(), Rule::unique('people', 'cpf')->ignore($personId)],
            'form.data_nascimento' => ['required', 'date', 'before:today'],
            'form.email' => ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255', Rule::unique('people', 'email')->ignore($personId)],
            'form.telefone' => ['required', 'string', 'regex:/^[0-9+\-\s()]{10,20}$/'],
        ];
    }


    public function save(PersonService $service)
    {
        if ($this->person) {
            $service->update($this->person, $this->form);
            session()->flash('status', 'Pessoa atualizada com sucesso.');
        } else {
            $this->person = $service->create($this->form);
            session()->flash('status', 'Pessoa criada com sucesso.');
        }

        return redirect()->route('people.index');
    }

    public function render()
    {
        return view('livewire.people.personform');
    }
}

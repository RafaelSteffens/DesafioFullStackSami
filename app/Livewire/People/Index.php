<?php

namespace App\Livewire\People;

use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $q = '';

    public int $perPage = 3;

    protected array $queryString = [
        'q' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected string $paginationTheme = 'tailwind';

    public function deletePerson(int $personId, PersonService $personService): void
    {
        try {
            $person = Person::findOrFail($personId);

            $personService->delete($person);

            session()->flash('status', 'Pessoa removida com sucesso.');
            $this->resetPage();
        } catch (Throwable $e) {
            Log::error('Erro ao remover pessoa', [
                'person_id' => $personId,
                'message'   => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'Ocorreu um erro ao remover a pessoa.');
        }
    }

    public function render(PersonService $personService): View
    {
        $people = $personService->paginate($this->q, $this->perPage);

        return view('livewire.people.index', [
            'people' => $people,
        ]);
    }
}

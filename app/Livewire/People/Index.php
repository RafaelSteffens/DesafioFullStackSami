<?php

namespace App\Livewire\People;

use App\Models\Person;
use App\Services\PersonService;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $q = '';

    public int $perPage = 10;

    protected array $queryString = [
        'q' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected string $paginationTheme = 'tailwind';

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function deletePerson(int $personId, PersonService $service): void
    {
        $person = Person::findOrFail($personId);
        $service->delete($person);

        session()->flash('status', 'Pessoa removida com sucesso.');
        $this->resetPage();
    }

    public function render(PersonService $service): \Illuminate\View\View
    {
        $people = $service->paginate($this->q, $this->perPage);

        return view('livewire.people.index', [
            'people' => $people,
        ]);
    }

}

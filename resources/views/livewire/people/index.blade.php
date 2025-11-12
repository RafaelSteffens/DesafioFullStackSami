<div class="space-y-6" wire:loading.class="opacity-60">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-800">Pessoas</h1>
            <p class="text-sm text-zinc-500">Gerencie o cadastro com busca e paginação.</p>
        </div>
        <a href="{{ route('people.create') }}"
           class="inline-flex items-center rounded-md bg-#0000 px-4 py-2 text-sm font-semibold text-black hover:bg-indigo-700 ">
           Nova Pessoa
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div class="w-full sm:max-w-xs">
                <label for="search" class="block text-sm font-medium text-zinc-700">Busca</label>
                <input id="search" type="search" placeholder="Nome, email ou CPF"
                       wire:model.live.debounce.500ms="q"
                       class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
            </div>
            <div>
                <span class="text-xs text-zinc-500">Registros</span>
                <div class="inline-block text-sm font-semibold bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-full">
                    {{ $people->total() }} encontrados
                </div>
            </div>
        </div>

        <div class="mt-4 overflow-x-auto border rounded-lg">
            <table class="min-w-full text-sm">
                <thead class="bg-zinc-50 text-xs uppercase text-zinc-500">
                    <tr>
                        <th class="px-3 py-2">Nome</th>
                        <th class="px-3 py-2">CPF</th>
                        <th class="px-3 py-2">Nascimento</th>
                        <th class="px-3 py-2">E-mail</th>
                        <th class="px-3 py-2">Telefone</th>
                        <th class="px-3 py-2 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($people as $person)
                        <tr wire:key="person-{{ $person->id }}">
                            <td class="px-3 py-3 font-medium text-zinc-800">{{ $person->nome }}</td>
                            <td class="px-3 py-3 text-zinc-600">{{ $person->cpf }}</td>
                            <td class="px-3 py-3 text-zinc-600">{{ optional($person->data_nascimento)->format('d/m/Y') }}</td>
                            <td class="px-3 py-3 text-zinc-600">{{ $person->email }}</td>
                            <td class="px-3 py-3 text-zinc-600">{{ $person->telefone }}</td>
                            <td class="px-3 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('people.edit', $person) }}"
                                       class="inline-flex items-center rounded-md border border-indigo-500 px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-50">
                                        Editar
                                    </a>
                                    <button type="button"
                                            onclick="if(!confirm('Tem certeza que deseja remover esta pessoa?')) return;"
                                            wire:click="deletePerson({{ $person->id }})"
                                            class="inline-flex items-center rounded-md border border-rose-500 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-6 text-center text-zinc-500">Nenhuma pessoa encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $people->links() }}
        </div>
    </div>
</div>

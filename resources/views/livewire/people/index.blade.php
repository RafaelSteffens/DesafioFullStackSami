<div class="space-y-6" wire:loading.class="opacity-60">
    <div class="w-full ">
        <header class="w-full bg-blue-900">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="/logo-sami.png" alt="Logo Sami Sistemas" style="height: 200px; width: 200px; margin-left: 15%;">
                    <span class="font-medium text-sm">Rafael Steffens <br> Dev Fulltack</span>
                </div>

                <a href="{{ route('people.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-black"
                   style="margin-right: 15%;">
                   <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                       <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                   </svg>
                   Cadastrar Pessoa
                </a>
            </div>
        </header>

        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                <!-- <div class="w-full sm:max-w-xs">
                    <label for="search" class="block text-sm font-medium">Busca</label>
                    <input id="search" type="search" placeholder="Nome, email ou CPF"
                           wire:model.live.debounce.500ms="q"
                           class="mt-1 w-full rounded-md border px-3 py-2 text-sm">
                </div> -->
                <div>
                    
                    <div class="">
                        {{ $people->total() }} Registros Encontrados
                    </div>
                </div>
            </div>

            <div class="mt-4 overflow-x-auto border rounded-lg">
                <table class="min-w-full text-sm">
                    <thead class="bg-zinc-50 text-xs ">
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
                                <td class="px-3 py-3 font-medium">{{ $person->nome }}</td>
                                <td class="px-3 py-3">{{ $person->cpf }}</td>
                                <td class="px-3 py-3">{{ optional($person->data_nascimento)->format('d/m/Y') }}</td>
                                <td class="px-3 py-3">{{ $person->email }}</td>
                                <td class="px-3 py-3">{{ $person->telefone }}</td>
                                <td class="px-3 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('people.edit', $person) }}"
                                           class="inline-flex items-center rounded-md border px-3 py-1.5 ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg>
                                        </a>
                                        <button type="button"
                                                onclick="if(!confirm('Tem certeza que deseja remover esta pessoa?')) return;"
                                                wire:click="deletePerson({{ $person->id }})"
                                                class="inline-flex items-center rounded-md border px-3 py-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-6 text-center">Nenhuma pessoa encontrada.</td>
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
</div>

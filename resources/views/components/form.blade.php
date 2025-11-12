<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <h1 class="text-2xl font-semibold text-zinc-800">
            {{ $person ? 'Editar Pessoa' : 'Nova Pessoa' }}
        </h1>
        <p class="text-sm text-zinc-500">
            Preencha os campos abaixo para {{ $person ? 'atualizar' : 'criar' }} uma pessoa.
        </p>
    </div>

    <form wire:submit.prevent="save" class="rounded-lg bg-white p-6 shadow-sm">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-zinc-700" for="nome">Nome</label>
                <input
                    id="nome"
                    type="text"
                    wire:model.blur="form.nome"
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                    placeholder="Nome completo"
                />
                @error('form.nome')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-zinc-700" for="cpf">CPF</label>
                <input
                    id="cpf"
                    type="text"
                    wire:model.blur="form.cpf"
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                    placeholder="000.000.000-00"
                />
                @error('form.cpf')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-zinc-700" for="data_nascimento">Data de nascimento</label>
                <input
                    id="data_nascimento"
                    type="date"
                    wire:model.blur="form.data_nascimento"
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                />
                @error('form.data_nascimento')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-zinc-700" for="email">E-mail</label>
                <input
                    id="email"
                    type="email"
                    wire:model.blur="form.email"
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                    placeholder="nome@exemplo.com"
                />
                @error('form.email')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-zinc-700" for="telefone">Telefone</label>
                <input
                    id="telefone"
                    type="text"
                    wire:model.blur="form.telefone"
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                    placeholder="(11) 99999-9999"
                />
                @error('form.telefone')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            <a
                href="{{ route('people.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-50"
            >
                Cancelar
            </a>
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
            >
                {{ $person ? 'Salvar alterações' : 'Criar pessoa' }}
            </button>
        </div>
    </form>
</div>

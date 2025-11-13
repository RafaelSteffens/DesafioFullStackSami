<div class="container mx-auto px-4 sm:px-6 lg:px-8">
  <div class="mx-auto max-w-3xl space-y-6 py-4 sm:py-6 lg:py-8">
    <div class="rounded-xl bg-blue-900 px-5 py-4">
        <h1 class="text-xl sm:text-2xl font-semibold text-white">
            {{ $person ? 'Editar Pessoa' : 'Nova Pessoa' }}
        </h1>
        <h2 class="mt-7 text-sm text-blue-100">
            Preencha os campos abaixo para {{ $person ? 'atualizar' : 'criar' }} uma pessoa.
        </h2>
    </div>

    <form wire:submit.prevent="save" class="rounded-xl border bg-white p-4 sm:p-6 shadow-sm">
        <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">
            <div class="md:col-span-2">
                <label for="nome" class="mb-1 block text-sm font-medium">Nome</label>
                <input
                    id="nome"
                    type="text"
                    placeholder="Nome completo"
                    wire:model.blur="form.nome"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm @error('form.nome')  @enderror"
                    aria-invalid="@error('form.nome') true @else false @enderror"
                />
                @error('form.nome')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="cpf" class="mb-1 block text-sm font-medium">CPF</label>
                <input
                    id="cpf"
                    type="text"
                    placeholder="000.000.000-00"
                    wire:model.blur="form.cpf"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm @error('form.cpf')  @enderror"
                    aria-invalid="@error('form.cpf') true @else false @enderror"
                />
                @error('form.cpf')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="data_nascimento" class="mb-1 block text-sm font-medium">Data de nascimento</label>
                <input
                    id="data_nascimento"
                    type="date"
                    wire:model.blur="form.data_nascimento"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm @error('form.data_nascimento')  @enderror"
                    aria-invalid="@error('form.data_nascimento') true @else false @enderror"
                />
                @error('form.data_nascimento')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">E-mail</label>
                <input
                    id="email"
                    type="email"
                    placeholder="nome@exemplo.com"
                    wire:model.blur="form.email"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm @error('form.email')  @enderror"
                    aria-invalid="@error('form.email') true @else false @enderror"
                />
                @error('form.email')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2 md:max-w-sm">
                <label for="telefone" class="mb-1 block text-sm font-medium">Telefone</label>
                <input
                    id="telefone"
                    type="text"
                    placeholder="(11) 99999-9999"
                    wire:model.blur="form.telefone"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm @error('form.telefone')  @enderror"
                    aria-invalid="@error('form.telefone') true @else false @enderror"
                />
                @error('form.telefone')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            <a
                href="{{ route('people.index') }}"
                class="inline-flex items-center justify-center rounded-lg border px-4 py-2 text-sm font-medium"
            >
                Cancelar
            </a>
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-black shadow-sm disabled:opacity-70 disabled:cursor-not-allowed"
            >
                <svg wire:loading wire:target="save" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"></path>
                </svg>
                {{ $person ? 'Salvar alterações' : 'Criar pessoa' }}
            </button>
        </div>
    </form>
  </div>
  <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('form-error', (message) => {
                alert('Erro ao salvar: ' + message);
            });
        });
  </script>
</div>

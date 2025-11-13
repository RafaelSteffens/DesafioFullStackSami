<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonStoreRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class PersonController extends Controller
{
    public function __construct(private readonly PersonService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = (int) $request->integer('per_page', 3);
            $perPage = max(1, min(3, $perPage));

            $people = $this->service->paginate(
                $request->string('q')->toString(),
                $perPage
            );

            return response()->json($people);

        } catch (Throwable $e) {
            Log::error('Erro ao listar pessoas', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar pessoas.',
            ], 500);
        }
    }

    public function store(PersonStoreRequest $request): JsonResponse
    {
        try {
            $person = $this->service->create($request->validated());

            return response()->json([
                'success' => true,
                'data'    => $person,
            ], 201);

        } catch (Throwable $e) {
            Log::error('Erro ao criar pessoa', [
                'input'   => $request->all(),
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar pessoa.',
            ], 500);
        }
    }

    public function update(PersonUpdateRequest $request, Person $person): JsonResponse
    {
        try {
            $updated = $this->service->update($person, $request->validated());

            return response()->json([
                'success' => true,
                'data'    => $updated,
            ]);

        } catch (Throwable $e) {
            Log::error('Erro ao atualizar pessoa', [
                'person_id' => $person->id,
                'input'     => $request->all(),
                'message'   => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar pessoa.',
            ], 500);
        }
    }

    public function destroy(Person $person): JsonResponse
    {
        try {
            $this->service->delete($person);

            return response()->json([
                'success' => true,
                'message' => "Pessoa removida com sucesso.",
            ]);

        } catch (Throwable $e) {
            Log::error('Erro ao deletar pessoa', [
                'person_id' => $person->id ?? null,
                'message'   => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar pessoa.',
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonStoreRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function __construct(private readonly PersonService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->integer('per_page', 3);
        $perPage = max(1, min(3, $perPage));

        $people = $this->service->paginate(
            $request->string('q')->toString(),
            $perPage
        );

        return response()->json($people);
    }


    public function destroy(Person $person): JsonResponse
    {
        $result = $this->service->delete($person);

        return response()->json($result);
    }
    
    public function store(PersonStoreRequest $request): JsonResponse
    {
        $person = $this->service->create($request->validated());
        return response()->json($person, 201);
    }

    public function storeFromArray(array $data): Person
    {
        return $this->service->create($data);
    }

    public function update(PersonUpdateRequest $request, Person $person): JsonResponse
    {
        $updated = $this->service->update($person, $request->validated());
        return response()->json($updated);
    }

    public function updateFromArray(Person $person, array $data): Person
    {
        return $this->service->update($person, $data);
    }


}

<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Services\Customer\StoreCustomerService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CustomerResource;

use Exception;

class CustomerController extends Controller
{
    protected $storeCustomerService;

    public function __construct(StoreCustomerService $storeCustomerService)
    {
        $this->storeCustomerService = $storeCustomerService;
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     tags={"Clientes"},
     *     summary="Criar um novo cliente",
     *     operationId="storeCustomer",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CustomerRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente criado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno ao criar cliente"
     *     )
     * )
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        try {
            $customer = $this->storeCustomerService->execute($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Cliente criado com sucesso.',
                'data' => new CustomerResource($customer)
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar cliente.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

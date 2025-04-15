<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Transaction\StoreTransactionDepositRequest;
use App\Services\Transaction\DepositService;
use App\Services\Transaction\RevertTransactionService;
use App\Services\Transaction\TransferService;
use App\Http\Requests\Transaction\StoreTransactionRevertRequest;
use App\Http\Requests\Transaction\StoreTransactionTransferRequest;
use App\Services\Transaction\GetMyTransactionsService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TransactionResource;

use Exception;

class TransactionController extends Controller
{
    protected $storeTransactionService;

    public function __construct(
        private DepositService $depositService,
        private RevertTransactionService $revertTransactionService,
        private TransferService $transferService,
        private GetMyTransactionsService $getMyTransactionsService
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Transações listadas com sucesso.',
            'data' => $this->getMyTransactionsService->execute()
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/transaction/deposit",
     *     tags={"Transações"},
     *     summary="Criar deposito",
     *     operationId="deposit",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TransactionDepositRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transação criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno ao criar transação"
     *     )
     * )
     */
    public function deposit(StoreTransactionDepositRequest $request): JsonResponse
    {
        try {
            $transaction = $this->depositService->execute($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Transação criada com sucesso.',
                'data' => new TransactionResource($transaction)
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar transação.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/transaction/revert",
     *     tags={"Transações"},
     *     summary="Reverter transação",
     *     operationId="revert",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TransactionRevertRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transação criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno ao criar transação"
     *     )
     * )
     */

    public function revert(StoreTransactionRevertRequest $request): JsonResponse
    {
        try {
            $transaction = $this->revertTransactionService->execute($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Transação revertida com sucesso.',
                'data' => new TransactionResource($transaction)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao reverter transação.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/transaction/transfer",
     *     tags={"Transações"},
     *     summary="Transferencia bancária",
     *     operationId="transfer",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TransactionTransferRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transação criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno ao criar transação"
     *     )
     * )
     */

    public function transfer(StoreTransactionTransferRequest $request): JsonResponse
    {
        try {
            $transaction = $this->transferService->execute($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Transação transferida com sucesso.',
                'data' => new TransactionResource($transaction)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao reverter transação.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

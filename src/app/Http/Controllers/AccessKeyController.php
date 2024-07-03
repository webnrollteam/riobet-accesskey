<?php

namespace Riobet\AccessKey\App\Http\Controllers;

use Riobet\AccessKey\App\Exceptions\BadUserInputException;
use Riobet\AccessKey\App\Services\AccessKeyService;
use Riobet\AccessKey\App\Http\Requests\AccessKeyListRequest;
use Riobet\AccessKey\App\Http\Requests\AccessKeyCreateRequest;
use Riobet\AccessKey\App\Http\Requests\AccessKeyUpdateRequest;

class AccessKeyController extends Controller
{
    public function __construct(
        private AccessKeyService $accessKeyService
    ) {
    }

    /**
     * Список ключей доступа
     *
     * @OA\Post(
     *   path="/api/accesskey",
     *   operationId="accesskey-list",
     *   tags={"AccessKey"},
     *   security={ {"apiKey": {}} },
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/AccessKeyListRequest")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Список ключей доступа",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/AccessKey")
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated",
     *   )   
     * )
     */
    public function list(AccessKeyListRequest $request)
    {
        $input = $request->all();
        $this->checkMasterkey($input['masterkey']);        
        return $this->accessKeyService->list();
    }

    /**
     * Создание ключа доступа
     *
     * @OA\Post(
     *   path="/api/accesskey/create",
     *   operationId="accesskey-create",
     *   tags={"AccessKey"},
     *   security={ {"apiKey": {}} },
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/AccessKeyCreateRequest")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Ключ доступа",
     *     @OA\JsonContent(ref="#/components/schemas/AccessKey")
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated",
     *   )   
     * )
     */
    public function create(AccessKeyCreateRequest $request)
    {
        $input = $request->all();
        $this->checkMasterkey($input['masterkey']);
        return response()->json($this->accessKeyService->create($input['params']), 200);
    }

    /**
     * Обновление ключа доступа
     *
     * @OA\Post(
     *   path="/api/accesskey/update",
     *   operationId="accesskey-update",
     *   tags={"AccessKey"},
     *   security={ {"apiKey": {}} },
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/AccessKeyUpdateRequest")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Ключ доступа",
     *     @OA\JsonContent(ref="#/components/schemas/AccessKey")
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated",
     *   )   
     * )
     */
    public function update(AccessKeyUpdateRequest $request)
    {
        $input = $request->all();
        $this->checkMasterkey($input['masterkey']);
        return $this->accessKeyService->update($input['accesskey'], $input['params']);
    }

    private function checkMasterkey($masterKey): bool
    {
        if ($masterKey != env('MASTERKEY')) {
            throw new BadUserInputException("Доступ запрещен", 403);
        }

        return true;
    }
}

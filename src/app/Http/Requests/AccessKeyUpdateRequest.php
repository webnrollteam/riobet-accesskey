<?php

namespace Riobet\AccessKey\App\Http\Requests;

/**
 * @OA\Schema(
 *   description="Создание ключа доступа",
 *   title="Создание ключа доступа",
 *   required={"masterkey", "accesskey", "params"},
 *   @OA\Xml(
 *     name="Создание ключа доступа"
 *   ),
 *   @OA\Property(
 *     property="masterkey",
 *     description="Мастер ключ",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="accesskey",
 *     description="Ключ доступа",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="params",
 *     description="Параметры",
 *     type="object"
 *   ),
 * )
 */
class AccessKeyUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'masterkey' => ['required', 'string'],
            'accesskey' => ['required', 'string'],
            'params' => ['required'],
        ];
    }
}

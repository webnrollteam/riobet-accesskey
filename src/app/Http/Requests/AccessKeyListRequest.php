<?php

namespace Riobet\AccessKey\App\Http\Requests;

/**
 * @OA\Schema(
 *   description="Список ключей доступа",
 *   title="Список ключей доступа",
 *   required={"masterkey"},
 *   @OA\Xml(
 *     name="Список ключей доступа"
 *   ),
 *   @OA\Property(
 *     property="masterkey",
 *     description="Мастер ключ",
 *     type="string"
 *   ),
 * )
 */
class AccessKeyListRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'masterkey' => ['required', 'string'],
        ];
    }
}

<?php

namespace Riobet\AccessKey\App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Riobet\AccessKey\App\Services\CryptoService;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

/**
 * @OA\Schema(
 *   description="Ключи доступа",
 *   title="Ключи доступа",
 *   required={"slug", "keypair"},
 *   @OA\Xml(
 *     name="Ключи доступа"
 *   ),
 *   @OA\Property(
 *     property="accesskey",
 *     description="Access key",
 *     format="string",
 *   ),
 *   @OA\Property(
 *     property="params",
 *     description="Access key params",
 *     format="object",
 *   ),
 * )
 * 
 * @property string $accesskey
 */
class AccessKey extends BaseModel
{
    use SoftDeletes;
    use HasTimestamps;

    protected $keyType = 'string';

    protected $primaryKey = 'accesskey';

    public $incrementing = false;
    
    protected $fillable = [
        'accesskey',
        'params'
    ];

    protected $hidden = [];

    protected $casts = [
        'accesskey' => 'string',
    ];

    public static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {
            $model->accesskey = static::decrypt($model->accesskey);
            $model->params = json_decode(static::decrypt($model->params), true);
        });

        static::saving(function ($model) {
            $model->accesskey = static::encrypt($model->accesskey);
            $model->params = static::encrypt(json_encode($model->params));
        });

        static::saved(function ($model) {
            $model->accesskey = static::decrypt($model->accesskey);
            $model->params = json_decode(static::decrypt($model->params), true);
        });
    }

    public static function encrypt($value)
    {
        $masterKey = env('MASTERKEY');
        if (!$masterKey) {
            return $value;
        }

        /** @var CryptoService $cryptoService */
        $cryptoService = app(CryptoService::class);
        return $cryptoService->encrypt($value, $masterKey);
    }

    public static function decrypt($data)
    {
        $masterKey = env('MASTERKEY');
        if (!$masterKey) {
            return $data;
        }

        /** @var CryptoService $cryptoService */
        $cryptoService = app(CryptoService::class);
        return $cryptoService->decrypt($data, $masterKey);
    }
}

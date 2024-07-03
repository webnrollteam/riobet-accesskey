<?php

namespace Riobet\AccessKey\App\Services;

use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Riobet\AccessKey\App\Models\AccessKey;

class AccessKeyService
{
    private LoggerInterface $logger;

    public function __construct(
        private CryptoService $cryptoService
    ) {
        $this->logger = Log::channel();
    }

    public function list(): Collection
    {
        $list = AccessKey::get();
        return $list;
    }

    public function create($params): AccessKey
    {
        $accessKey = Str::uuid();
        $accessKey = AccessKey::create([
            'accesskey' => $accessKey,
            'params' => $params
        ]);

        return $accessKey;
    }

    public function update($accessKey, $params): AccessKey
    {
        $accessKeyEncoded = $this->cryptoService->encrypt($accessKey, env('MASTERKEY'));
        $accessKeyEntity = AccessKey::find($accessKeyEncoded);
        $accessKeyEntity->update([
            'params' => $params
        ]);

        return $accessKeyEntity;
    }

    public function check($accessKey): bool
    {
        $accessKeyEncoded = $this->cryptoService->encrypt($accessKey, env('MASTERKEY'));
        return AccessKey::find($accessKeyEncoded) != null;
    }
}

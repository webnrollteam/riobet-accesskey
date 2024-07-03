<?php

namespace Riobet\AccessKey\App\Services;

use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Log;
use Riobet\AccessKey\App\Exceptions\BadUserInputException;

class CryptoService
{
    private LoggerInterface $logger;

    public function __construct() {
        $this->logger = Log::channel();
    }

    public function encrypt(string $message, string $key)
    {
        $secretKey = sodium_base642bin($key, SODIUM_BASE64_VARIANT_ORIGINAL);
        $nonce = str_repeat('0', SODIUM_CRYPTO_BOX_NONCEBYTES);
        $ciphertext = sodium_crypto_secretbox($message, $nonce, $secretKey);
        $result = sodium_bin2base64($nonce . $ciphertext, SODIUM_BASE64_VARIANT_ORIGINAL);
        sodium_memzero($message);
        sodium_memzero($nonce);
        sodium_memzero($secretKey);
        return $result;
    }

    public function decrypt(string $encrypted, string $key)
    {
        $secretKey = sodium_base642bin($key, SODIUM_BASE64_VARIANT_ORIGINAL);
        $ciphertext = sodium_base642bin($encrypted, SODIUM_BASE64_VARIANT_ORIGINAL);
        $nonce = mb_substr($ciphertext, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        $ciphertext = mb_substr($ciphertext, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
        $plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, $secretKey);

        if ($plaintext === false) {
            $this->logger->error("Ошибка симметричного дешифрования {$encrypted}");
            throw new BadUserInputException('Ошибка симметричного дешифрования');
        }
        sodium_memzero($nonce);
        sodium_memzero($secretKey);
        sodium_memzero($ciphertext);
        return $plaintext;
    }
}

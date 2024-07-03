<?php

namespace Riobet\AccessKey\App\Exceptions;

class BadUserInputException extends \Exception
{
    public function __construct(
        $message,
        $code = null,
        \Throwable|null $previous = null
    ) {
        parent::__construct($message, $code ?? 400, $previous);
    }
}

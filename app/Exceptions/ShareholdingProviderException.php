<?php

namespace App\Exceptions;

use RuntimeException;

class ShareholdingProviderException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly int $status,
        public readonly ?array $error = null
    ) {
        parent::__construct($message, $status);
    }
}

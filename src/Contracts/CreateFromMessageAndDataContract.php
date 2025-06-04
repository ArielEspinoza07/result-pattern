<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Contracts;

use ArielEspinoza07\ResultPattern\Result;

interface CreateFromMessageAndDataContract
{
    public static function fromMessageAndData(string $message, array $data): Result;
}

<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Contracts;

interface CreateFromMessageContract
{
    public static function fromMessage(string $message): Result;
}

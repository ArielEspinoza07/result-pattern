<?php

declare(strict_types=1);

interface CreateFromMessageAndDataContract
{
    public static function fromMessageAndData(string $message, array $data): Result;
}

<?php

declare(strict_types=1);

interface CreateFromMessageContract
{
    public static function fromMessage(string $message): Result;
}

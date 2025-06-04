<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

abstract readonly class Result
{
    private function __construct(
        private bool $isSuccess,
        private string $message,
        private int $status,
        private array $data,
    ) {}

    abstract public static function from(string|null $message = null, array $data = []): Result;

    public static function create(
        bool $isSuccess,
        string $message,
        int $status,
        array $data,
    ): Result {
        return new static($isSuccess, $message, $status, $data);
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message(),
            'data' => $this->data(),
        ];
    }
}

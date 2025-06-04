<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

/**
 * @phpstan-consistent-constructor
 */
abstract readonly class Result
{
    private function __construct(
        private bool $isSuccess,
        private string $message,
        private int $status,
        /** @var array<string, mixed> */
        private array $data,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    abstract public static function from(?string $message = null, array $data = []): Result;

    /**
     * @param array<string, mixed> $data
     */
    public static function create(
        bool $isSuccess,
        string $message,
        int $status,
        array $data,
    ): static {
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

    /**
     * @return array<string, mixed>
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * @return array{success: bool, message: string, status: int, data: array<string, mixed>}
     */
    public function toArray(): array
    {
        return [
            'success' => $this->isSuccess(),
            'message' => $this->message(),
            'status' => $this->status(),
            'data' => $this->data(),
        ];
    }
}

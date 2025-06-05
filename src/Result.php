<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;

/**
 * @phpstan-consistent-constructor
 *
 *
 * @property-read array<empty>|array<string, mixed> $data
 */
abstract readonly class Result
{
    private function __construct(
        private bool $isSuccess,
        private string $message,
        private int $status,
        /** @var array<string, mixed> */
        private array $data,
    ) {
    }

    /**
     * @param array<string, mixed>|null $data
     */
    abstract public static function from(
        ?string $message = null,
        HttpResponseStatusCode|int|null $status = null,
        ?array $data = []
    ): self;

    /**
     * @param array<string, mixed> $data
     */
    final public static function create(
        bool $isSuccess,
        string $message,
        int $status,
        array $data = [],
    ): static {
        return new static($isSuccess, $message, $status, $data);
    }

    final public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    final public function message(): string
    {
        return $this->message;
    }

    final public function status(): int
    {
        return $this->status;
    }

    /**
     * @return array<string, mixed>
     */
    final public function data(): array
    {
        return $this->data;
    }

    /**
     * @return array{success: bool, message: string, status: int, data: array<string, mixed>}
     */
    final public function toArray(): array
    {
        return [
            'success' => $this->isSuccess(),
            'message' => $this->message(),
            'status' => $this->status(),
            'data' => $this->data(),
        ];
    }
}

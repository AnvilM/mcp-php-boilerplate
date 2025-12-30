<?php

declare(strict_types=1);

namespace Application\Bootloaders;

use OutOfBoundsException;

/**
 * A generic immutable context object that holds typed key-value data.
 * Uses variadic template to track exact keys and their types throughout the application bootstrapping process.
 *
 * @template T of array<string, mixed> The shape of the data stored in the context (associative array with string keys)
 */
final readonly class Context
{
    /**
     * Internal storage for context data.
     *
     * @var T
     */
    private array $data;

    /**
     * Creates a new context instance.
     *
     * @param T $data Initial data to populate the context. Defaults to empty array.
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Retrieves a value from the context by key.
     * Throws if the key does not exist — this ensures type safety via PHPStan.
     *
     * @template TKey as key-of<T>
     *
     * @param TKey $key The key to retrieve
     *
     * @throws OutOfBoundsException If the key is not present in the context
     *
     * @return T[TKey] The value associated with the key
     */
    public function get(string $key): mixed
    {
        if (!array_key_exists($key, $this->data)) {
            throw new OutOfBoundsException("Key '$key' not found in context");
        }

        return $this->data[$key];
    }
}

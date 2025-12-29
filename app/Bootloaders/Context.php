<?php

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
     * Returns the full data array stored in the context.
     *
     * @return T The complete data array with all keys and values added so far
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Retrieves a value from the context by key.
     * Throws if the key does not exist — this ensures type safety via PHPStan.
     *
     * @template TKey as key-of<T>
     * @param TKey $key The key to retrieve
     * @return T[TKey] The value associated with the key
     *
     * @throws OutOfBoundsException If the key is not present in the context
     */
    public function get(string $key): mixed
    {
        if (!array_key_exists($key, $this->data)) {
            throw new OutOfBoundsException("Key '$key' not found in context");
        }

        return $this->data[$key];
    }

    /**
     * Returns a new immutable context with an additional or updated key-value pair.
     * The returned context has an extended type that includes the new key and value type.
     *
     * @template K as string
     * @template V as mixed
     * @param K $key The key to add or update
     * @param V $value The value to associate with the key
     * @return Context<T & array{K: V}> A new context instance with the added/updated key
     */
    public function with(string $key, mixed $value): self
    {
        /** @var Context<T & array{K: V}> $newContext */
        $newContext = new self([...$this->data, $key => $value]);

        return $newContext;
    }
}
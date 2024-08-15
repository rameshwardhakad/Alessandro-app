<?php

namespace Spack\Contracts;

interface Colorable
{
    /**
     * Get specific color with key.
     */
    public function get(string $key): ?string;

    /**
     * Get all color items.
     */
    public function all(): array;

    /**
     * Get the default color.
     */
    public function default(): string;

    /**
     * Get color items as options.
     */
    public function options(): array;

    /**
     * Prepare the object for JSON serialization.
     */
    public function jsonSerialize(): array;
}

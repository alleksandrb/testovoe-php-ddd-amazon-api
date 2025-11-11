<?php

declare(strict_types=1);

namespace App\Domain\Entities;

/**
 * Amazon Buyer implementation of BuyerInterface
 */
class Buyer implements BuyerInterface
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * Get display name for buyer
     */
    public function getDisplayName(): string
    {
        return $this->data['shop_username'] ?? $this->data['name'] ?? 'Unknown Buyer';
    }
}

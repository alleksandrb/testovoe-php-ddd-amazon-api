<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

/**
 * Value Object for Order Product information
 */
class OrderProductVO
{
    public function __construct(
        private readonly string $sku,
        private readonly int $quantity,
        private readonly ?string $orderProductId = null
    ) {
        if (empty($this->sku)) {
            throw new \InvalidArgumentException('Product SKU cannot be empty');
        }

        if ($this->quantity <= 0) {
            throw new \InvalidArgumentException('Product quantity must be greater than 0');
        }
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getOrderProductId(): ?string
    {
        return $this->orderProductId;
    }
}

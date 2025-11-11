<?php

declare(strict_types=1);

namespace App\Infrastructure\Amazon\DTO;

/**
 * Data Transfer Object for Amazon FBA Fulfillment Order Item
 * Represents a single item in a fulfillment order
 */
class FBAFulfillmentOrderItemDTO
{
    /**
     * @param  string  $sku  Product SKU
     * @param  int  $quantity  Item quantity
     * @param  string|null  $orderProductId  Order product ID (optional)
     */
    public function __construct(
        private readonly string $sku,
        private readonly int $quantity,
        private readonly ?string $orderProductId = null
    ) {
        if (empty($this->sku)) {
            throw new \InvalidArgumentException('Product SKU cannot be empty');
        }

        if ($this->quantity <= 0) {
            throw new \InvalidArgumentException('Item quantity must be greater than 0');
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

    /**
     * Convert item to array format expected by Amazon FBA API
     */
    public function toArray(): array
    {
        $itemArray = [
            'sku' => $this->sku,
            'ammount' => $this->quantity,
            'quantity' => $this->quantity,
        ];

        if ($this->orderProductId !== null) {
            $itemArray['order_product_id'] = $this->orderProductId;
        }

        return $itemArray;
    }
}

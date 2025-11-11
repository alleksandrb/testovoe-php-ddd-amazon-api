<?php

declare(strict_types=1);

namespace App\Infrastructure\Amazon\DTO;

/**
 * Data Transfer Object for Amazon FBA Fulfillment Order
 * Contains data structure required for createFulfillmentOrder API call
 */
class FBAFulfillmentOrderDTO
{
    /**
     * @param  int  $orderId  Original order ID
     * @param  string  $sellerFulfillmentOrderId  Unique seller fulfillment order ID
     * @param  string  $displayableOrderId  Displayable order ID for customer
     * @param  string  $marketplaceId  Amazon marketplace ID
     * @param  string  $orderDate  Order date (ISO format)
     * @param  string  $comments  Order comments
     * @param  string  $shippingSpeedCategory  Shipping speed category (Standard, Expedited, Priority, ScheduledDelivery)
     * @param  string  $buyerName  Buyer display name
     * @param  string  $shippingStreet  Shipping street address
     * @param  string  $shippingCity  Shipping city
     * @param  string  $shippingState  Shipping state
     * @param  string  $shippingZip  Shipping zip code
     * @param  string  $shippingCountry  Shipping country (2-letter ISO code)
     * @param  FBAFulfillmentOrderItemDTO[]  $items  Order items
     */
    public function __construct(
        private readonly int $orderId,
        private readonly string $sellerFulfillmentOrderId,
        private readonly string $displayableOrderId,
        private readonly string $marketplaceId,
        private readonly string $orderDate,
        private readonly string $comments,
        private readonly string $shippingSpeedCategory,
        private readonly string $buyerName,
        private readonly string $shippingStreet,
        private readonly string $shippingCity,
        private readonly string $shippingState,
        private readonly string $shippingZip,
        private readonly string $shippingCountry,
        private readonly array $items
    ) {}

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getSellerFulfillmentOrderId(): string
    {
        return $this->sellerFulfillmentOrderId;
    }

    public function getDisplayableOrderId(): string
    {
        return $this->displayableOrderId;
    }

    public function getMarketplaceId(): string
    {
        return $this->marketplaceId;
    }

    public function getOrderDate(): string
    {
        return $this->orderDate;
    }

    public function getComments(): string
    {
        return $this->comments;
    }

    public function getShippingSpeedCategory(): string
    {
        return $this->shippingSpeedCategory;
    }

    public function getBuyerName(): string
    {
        return $this->buyerName;
    }

    public function getShippingStreet(): string
    {
        return $this->shippingStreet;
    }

    public function getShippingCity(): string
    {
        return $this->shippingCity;
    }

    public function getShippingState(): string
    {
        return $this->shippingState;
    }

    public function getShippingZip(): string
    {
        return $this->shippingZip;
    }

    public function getShippingCountry(): string
    {
        return $this->shippingCountry;
    }

    /**
     * @return FBAFulfillmentOrderItemDTO[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}

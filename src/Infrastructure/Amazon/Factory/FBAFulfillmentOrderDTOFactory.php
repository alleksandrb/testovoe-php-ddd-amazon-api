<?php

declare(strict_types=1);

namespace App\Infrastructure\Amazon\Factory;

use App\Domain\Entities\AbstractOrder;
use App\Domain\Entities\AmazonOrder;
use App\Domain\Entities\Buyer;
use App\Domain\Entities\BuyerInterface;
use App\Infrastructure\Amazon\DTO\FBAFulfillmentOrderDTO;
use App\Infrastructure\Amazon\DTO\FBAFulfillmentOrderItemDTO;
use InvalidArgumentException;

class FBAFulfillmentOrderDTOFactory
{
    public function create(AbstractOrder $order, BuyerInterface $buyer, string $marketplaceId): FBAFulfillmentOrderDTO
    {
        if (! $order instanceof AmazonOrder) {
            throw new InvalidArgumentException('Order must be an instance of AmazonOrder');
        }

        if (! $buyer instanceof Buyer) {
            throw new InvalidArgumentException('Buyer must be an instance of Buyer');
        }

        $shippingAddress = $order->getShippingAddress();

        $items = [];
        foreach ($order->getProducts() as $product) {
            $items[] = new FBAFulfillmentOrderItemDTO(
                sku: $product->getSku(),
                quantity: $product->getQuantity(),
                orderProductId: $product->getOrderProductId()
            );
        }

        return new FBAFulfillmentOrderDTO(
            orderId: $order->getOrderId(),
            sellerFulfillmentOrderId: $order->generateSellerFulfillmentOrderId(),
            displayableOrderId: $order->getOrderUnique(),
            marketplaceId: $marketplaceId,
            orderDate: $order->getOrderDate(),
            comments: $order->getComments(),
            shippingSpeedCategory: $order->getShippingSpeedCategory(),
            buyerName: $buyer->getDisplayName(),
            shippingStreet: $shippingAddress->getStreet(),
            shippingCity: $shippingAddress->getCity(),
            shippingState: $shippingAddress->getState(),
            shippingZip: $shippingAddress->getZip(),
            shippingCountry: $shippingAddress->getCountry(),
            items: $items
        );
    }
}

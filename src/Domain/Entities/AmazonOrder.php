<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\OrderProductVO;
use App\Domain\ValueObjects\ShippingAddressVO;
use RuntimeException;

class AmazonOrder extends AbstractOrder
{
    private ?ShippingAddressVO $shippingAddress = null;

    /**
     * @var OrderProductVO[]
     */
    private ?array $orderProducts = null;

    protected function loadOrderData(int $id): array
    {
        $mockPath = __DIR__.'/../../../mock/order.'.$id.'.json';
        $normalizedPath = realpath($mockPath);
        if ($normalizedPath === false || ! file_exists($normalizedPath)) {
            throw new RuntimeException('Order data not found for ID: '.$id);
        }
        $orderData = json_decode(file_get_contents($normalizedPath), true);

        if (! is_array($orderData)) {
            throw new RuntimeException('Invalid order data for ID: '.$id);
        }

        return $orderData;
    }

    public function generateSellerFulfillmentOrderId(): string
    {
        return 'FBA'.date('Ymd').$this->getOrderId().rand(100000, 999999);
    }

    public function getOrderUnique(): string
    {
        return $this->data['order_unique'];
    }

    public function getOrderDate(): string
    {
        return $this->data['order_date'];
    }

    public function getComments(): string
    {
        return $this->data['comments'];
    }

    public function getShippingSpeedCategory(): string
    {
        return $this->data['shiping_name'];
    }

    public function getShippingAddress(): ShippingAddressVO
    {
        if ($this->shippingAddress) {
            return $this->shippingAddress;
        }
        $this->shippingAddress = new ShippingAddressVO(
            street: $this->data['shipping_street'],
            city: $this->data['shipping_city'],
            state: $this->data['shipping_state'],
            zip: $this->data['shipping_zip'],
            country: $this->data['shipping_country']
        );

        return $this->shippingAddress;
    }

    public function getProducts(): array
    {
        if ($this->orderProducts) {
            return $this->orderProducts;
        }
        $this->orderProducts = array_map(function ($product) {
            return new OrderProductVO(
                sku: $product['sku'],
                quantity: (int) $product['ammount'],
                orderProductId: $product['order_product_id'],
            );
        }, $this->data['products']);

        return $this->orderProducts;
    }
}

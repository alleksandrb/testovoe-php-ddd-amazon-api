<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Interfaces\ShipOrderServiceInterface;
use App\Domain\Interfaces\BuyerRepositoryInterface;
use App\Domain\Interfaces\OrderRepositoryInterface;
use App\Domain\Interfaces\ShippingServiceInterface;

class ShipOrderService implements ShipOrderServiceInterface
{
    public function __construct(
        private ShippingServiceInterface $shippingService,
        private OrderRepositoryInterface $orderRepository,
        private BuyerRepositoryInterface $buyerRepository,
    ) {}

    public function handle(int $orderId, int $buyerId): string
    {
        $order = $this->orderRepository->getOrderById($orderId);
        $buyer = $this->buyerRepository->getBuyerById($buyerId);

        return $this->shippingService->ship($order, $buyer);
    }
}

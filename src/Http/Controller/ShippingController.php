<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Application\Interfaces\ShipOrderServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ShippingController
{
    public function __construct(
        private ShipOrderServiceInterface $shipOrderService,
    ) {}

    public function shipOrder(Request $request): JsonResponse
    {
        $orderId = $request->getPayload()->get('order_id');
        $buyerId = $request->getPayload()->get('buyer_id');
        
        if (! $orderId || ! $buyerId) {
            throw new \InvalidArgumentException('Order ID and buyer ID are required');
        }

        $trackingNumber = $this->shipOrderService->handle(
            (int) $orderId,
            (int) $buyerId
        );

        return new JsonResponse([
            'success' => true,
            'tracking_number' => $trackingNumber,
        ], JsonResponse::HTTP_OK);

    }
}

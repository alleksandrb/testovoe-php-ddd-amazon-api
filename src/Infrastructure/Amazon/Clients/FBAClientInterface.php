<?php

declare(strict_types=1);

namespace App\Infrastructure\Amazon\Clients;

use App\Infrastructure\Amazon\DTO\FBAFulfillmentOrderDTO;

interface FBAClientInterface
{
    /**
     * @throws \RuntimeException If the operation cannot be performed
     */
    public function createFulfillmentOrder(FBAFulfillmentOrderDTO $fbaOrderDTO): CreateFulfillmentOrderResponse;

    /**
     * @throws \RuntimeException If the operation cannot be performed
     */
    public function getFulfillmentOrder(string $sellerFulfillmentOrderId): GetFulfillmentOrderResponse;
}

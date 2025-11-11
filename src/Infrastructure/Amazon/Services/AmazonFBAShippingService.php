<?php

declare(strict_types=1);

namespace App\Infrastructure\Amazon\Services;

use App\Domain\Entities\AbstractOrder;
use App\Domain\Entities\BuyerInterface;
use App\Domain\Interfaces\ShippingServiceInterface;
use App\Infrastructure\Amazon\Clients\FBAClientInterface;
use App\Infrastructure\Amazon\Factory\FBAFulfillmentOrderDTOFactory;
use RuntimeException;

class AmazonFBAShippingService implements ShippingServiceInterface
{
    public function __construct(
        private FBAClientInterface $fbaClient,
        private FBAFulfillmentOrderDTOFactory $fbaOrderDTOFactory,
        private string $marketplaceId
    ) {}

    /**
     * @throws RuntimeException
     */
    public function ship(AbstractOrder $order, BuyerInterface $buyer): string
    {
        $fbaOrderDTO = $this->fbaOrderDTOFactory->create($order, $buyer, $this->marketplaceId);

        $createFulfillmentOrderResponse = $this->fbaClient->createFulfillmentOrder($fbaOrderDTO);

        if (! $createFulfillmentOrderResponse->isSuccess()) {
            throw new RuntimeException($createFulfillmentOrderResponse->getErrorMessage());
        }

        $sellerFulfillmentOrderId = $fbaOrderDTO->getSellerFulfillmentOrderId();

        $fullfilmentOrderResponse = $this->fbaClient->getFulfillmentOrder($sellerFulfillmentOrderId);

        return $fullfilmentOrderResponse->getTrackingNumber();
    }
}

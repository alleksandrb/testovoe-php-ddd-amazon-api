<?php

declare(strict_types=1);

namespace App\Infrastructure\Amazon\Clients;

class GetFulfillmentOrderResponse extends FBAClientResponseAbstract
{
    public function getTrackingNumber(): string
    {
        return $this->body['payload']['fulfillmentShipments'][0]['fulfillmentShipmentPackage'][0]['trackingNumber'];

    }
}

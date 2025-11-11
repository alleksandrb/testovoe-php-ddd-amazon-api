<?php

declare(strict_types=1);

namespace App\Infrastructure\Amazon\Clients;

use App\Infrastructure\Amazon\DTO\FBAFulfillmentOrderDTO;
use RuntimeException;

class FBAClient implements FBAClientInterface
{
    /**
     * @throws RuntimeException
     */
    public function createFulfillmentOrder(FBAFulfillmentOrderDTO $fbaOrderDTO): CreateFulfillmentOrderResponse
    {
        return new CreateFulfillmentOrderResponse(
            statusCode: 200,
            body: [],
            errorMessage: null,
            headers: [],
        );
    }

    /**
     * @throws RuntimeException
     */
    public function getFulfillmentOrder(string $sellerFulfillmentOrderId): GetFulfillmentOrderResponse
    {
        return new GetFulfillmentOrderResponse(
            statusCode: 200,
            body: [
                'payload' => [
                    'fulfillmentOrder' => [
                        'sellerFulfillmentOrderId' => 'string',
                        'marketplaceId' => 'string',
                        'displayableOrderId' => 'string',
                        'displayableOrderDate' => '2025-11-06T07:02:02.871Z',
                        'displayableOrderComment' => 'string',
                        'shippingSpeedCategory' => 'Standard',
                        'deliveryWindow' => [
                            'startDate' => '2025-11-06T07:02:02.871Z',
                            'endDate' => '2025-11-06T07:02:02.871Z',
                        ],
                        'destinationAddress' => [
                            'name' => 'string',
                            'addressLine1' => 'string',
                            'addressLine2' => 'string',
                            'addressLine3' => 'string',
                            'city' => 'string',
                            'districtOrCounty' => 'string',
                            'stateOrRegion' => 'string',
                            'postalCode' => 'string',
                            'countryCode' => 'string',
                            'phone' => 'string',
                        ],
                        'fulfillmentAction' => 'Ship',
                        'fulfillmentPolicy' => 'FillOrKill',
                        'codSettings' => [
                            'isCodRequired' => true,
                            'codCharge' => [
                                'currencyCode' => 'string',
                                'value' => 'string',
                            ],
                            'codChargeTax' => [
                                'currencyCode' => 'string',
                                'value' => 'string',
                            ],
                            'shippingCharge' => [
                                'currencyCode' => 'string',
                                'value' => 'string',
                            ],
                            'shippingChargeTax' => [
                                'currencyCode' => 'string',
                                'value' => 'string',
                            ],
                        ],
                        'receivedDate' => '2025-11-06T07:02:02.871Z',
                        'fulfillmentOrderStatus' => 'New',
                        'statusUpdatedDate' => '2025-11-06T07:02:02.871Z',
                        'notificationEmails' => ['string'],
                        'featureConstraints' => [
                            [
                                'featureName' => 'string',
                                'featureFulfillmentPolicy' => 'Required',
                            ],
                        ],
                    ],
                    'fulfillmentOrderItems' => [
                        [
                            'sellerSku' => 'string',
                            'sellerFulfillmentOrderItemId' => 'string',
                            'quantity' => 0,
                            'giftMessage' => 'string',
                            'displayableComment' => 'string',
                            'fulfillmentNetworkSku' => 'string',
                            'orderItemDisposition' => 'string',
                            'cancelledQuantity' => 0,
                            'unfulfillableQuantity' => 0,
                            'estimatedShipDate' => '2025-11-06T07:02:02.871Z',
                            'estimatedArrivalDate' => '2025-11-06T07:02:02.871Z',
                            'perUnitPrice' => [
                                'currencyCode' => 'string',
                                'value' => 'string',
                            ],
                            'perUnitTax' => [
                                'currencyCode' => 'string',
                                'value' => 'string',
                            ],
                            'perUnitDeclaredValue' => [
                                'currencyCode' => 'string',
                                'value' => 'string',
                            ],
                        ],
                    ],
                    'fulfillmentShipments' => [
                        [
                            'amazonShipmentId' => 'string',
                            'fulfillmentCenterId' => 'string',
                            'fulfillmentShipmentStatus' => 'PENDING',
                            'shippingDate' => '2025-11-06T07:02:02.871Z',
                            'estimatedArrivalDate' => '2025-11-06T07:02:02.871Z',
                            'shippingNotes' => ['string'],
                            'fulfillmentShipmentItem' => [
                                [
                                    'sellerSku' => 'string',
                                    'sellerFulfillmentOrderItemId' => 'string',
                                    'quantity' => 0,
                                    'packageNumber' => 0,
                                    'serialNumber' => 'string',
                                    'manufacturerLotCodes' => ['string'],
                                ],
                            ],
                            'fulfillmentShipmentPackage' => [
                                [
                                    'packageNumber' => 0,
                                    'carrierCode' => 'string',
                                    'trackingNumber' => 'TRACKING_NUMBER1234567890',
                                    'amazonFulfillmentTrackingNumber' => 'string',
                                    'estimatedArrivalDate' => '2025-11-06T07:02:02.871Z',
                                    'lockerDetails' => [
                                        'lockerNumber' => 'string',
                                        'lockerAccessCode' => 'string',
                                    ],
                                    'deliveryInformation' => [
                                        'deliveryDocumentList' => [
                                            [
                                                'documentType' => 'string',
                                                'url' => 'string',
                                            ],
                                        ],
                                        'dropOffLocation' => [
                                            'type' => 'FRONT_DOOR',
                                            'attributes' => [
                                                'additionalProp' => 'string',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'returnItems' => [
                        [
                            'sellerReturnItemId' => 'string',
                            'sellerFulfillmentOrderItemId' => 'string',
                            'amazonShipmentId' => 'string',
                            'sellerReturnReasonCode' => 'string',
                            'returnComment' => 'string',
                            'amazonReturnReasonCode' => 'string',
                            'status' => 'New',
                            'statusChangedDate' => '2025-11-06T07:02:02.871Z',
                            'returnAuthorizationId' => 'string',
                            'returnReceivedCondition' => 'Sellable',
                            'fulfillmentCenterId' => 'string',
                        ],
                    ],
                    'returnAuthorizations' => [
                        [
                            'returnAuthorizationId' => 'string',
                            'fulfillmentCenterId' => 'string',
                            'returnToAddress' => [
                                'name' => 'string',
                                'addressLine1' => 'string',
                                'addressLine2' => 'string',
                                'addressLine3' => 'string',
                                'city' => 'string',
                                'districtOrCounty' => 'string',
                                'stateOrRegion' => 'string',
                                'postalCode' => 'string',
                                'countryCode' => 'string',
                                'phone' => 'string',
                            ],
                            'amazonRmaId' => 'string',
                            'rmaPageURL' => 'string',
                        ],
                    ],
                    'paymentInformation' => [
                        [
                            'paymentTransactionId' => 'string',
                            'paymentMode' => 'string',
                            'paymentDate' => '2025-11-06T07:02:02.871Z',
                        ],
                    ],
                ],
                'errors' => [
                    [
                        'code' => 'string',
                        'message' => 'string',
                        'details' => 'string',
                    ],
                ],
            ],
            errorMessage: null,
            headers: [],
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Amazon\Services;

use App\Domain\Entities\AbstractOrder;
use App\Domain\Entities\AmazonOrder;
use App\Domain\Entities\Buyer;
use App\Domain\Entities\BuyerInterface;
use App\Infrastructure\Amazon\Clients\CreateFulfillmentOrderResponse;
use App\Infrastructure\Amazon\Clients\FBAClientInterface;
use App\Infrastructure\Amazon\Clients\GetFulfillmentOrderResponse;
use App\Infrastructure\Amazon\DTO\FBAFulfillmentOrderDTO;
use App\Infrastructure\Amazon\Factory\FBAFulfillmentOrderDTOFactory;
use App\Infrastructure\Amazon\Services\AmazonFBAShippingService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class AmazonFBAShippingServiceTest extends TestCase
{
    private FBAClientInterface&MockObject $fbaClient;

    private FBAFulfillmentOrderDTOFactory&MockObject $fbaOrderDTOFactory;

    private AmazonFBAShippingService $service;

    private string $marketplaceId;

    protected function setUp(): void
    {
        $this->fbaClient = $this->createMock(FBAClientInterface::class);
        $this->fbaOrderDTOFactory = $this->createMock(FBAFulfillmentOrderDTOFactory::class);
        $this->marketplaceId = 'ATVPDKIKX0DER';

        $this->service = new AmazonFBAShippingService(
            $this->fbaClient,
            $this->fbaOrderDTOFactory,
            $this->marketplaceId
        );
    }

    public function test_ship_returns_tracking_number_on_success(): void
    {
        // Arrange
        /** @var AbstractOrder&MockObject $order */
        $order = $this->createMock(AmazonOrder::class);
        /** @var BuyerInterface&MockObject $buyer */
        $buyer = $this->createMock(Buyer::class);
        $sellerFulfillmentOrderId = 'FBA202401161234567890';
        $expectedTrackingNumber = '1Z999AA10123456784';

        $fbaOrderDTO = $this->createMock(FBAFulfillmentOrderDTO::class);
        $fbaOrderDTO->expects($this->once())
            ->method('getSellerFulfillmentOrderId')
            ->willReturn($sellerFulfillmentOrderId);

        $createResponse = $this->createMock(CreateFulfillmentOrderResponse::class);
        $createResponse->expects($this->once())
            ->method('isSuccess')
            ->willReturn(true);

        $getResponse = $this->createMock(GetFulfillmentOrderResponse::class);
        $getResponse->expects($this->once())
            ->method('getTrackingNumber')
            ->willReturn($expectedTrackingNumber);

        $this->fbaOrderDTOFactory->expects($this->once())
            ->method('create')
            ->with($order, $buyer, $this->marketplaceId)
            ->willReturn($fbaOrderDTO);

        $this->fbaClient->expects($this->once())
            ->method('createFulfillmentOrder')
            ->with($fbaOrderDTO)
            ->willReturn($createResponse);

        $this->fbaClient->expects($this->once())
            ->method('getFulfillmentOrder')
            ->with($sellerFulfillmentOrderId)
            ->willReturn($getResponse);

        // Act
        $result = $this->service->ship($order, $buyer);

        // Assert
        $this->assertEquals($expectedTrackingNumber, $result);
    }

    public function test_ship_throws_runtime_exception_when_create_fulfillment_order_fails(): void
    {
        // Arrange
        /** @var AbstractOrder&MockObject $order */
        $order = $this->createMock(AmazonOrder::class);
        /** @var BuyerInterface&MockObject $buyer */
        $buyer = $this->createMock(Buyer::class);
        $errorMessage = 'Invalid order data';

        $fbaOrderDTO = $this->createMock(FBAFulfillmentOrderDTO::class);

        $createResponse = $this->createMock(CreateFulfillmentOrderResponse::class);
        $createResponse->expects($this->once())
            ->method('isSuccess')
            ->willReturn(false);
        $createResponse->expects($this->once())
            ->method('getErrorMessage')
            ->willReturn($errorMessage);

        $this->fbaOrderDTOFactory->expects($this->once())
            ->method('create')
            ->with($order, $buyer, $this->marketplaceId)
            ->willReturn($fbaOrderDTO);

        $this->fbaClient->expects($this->once())
            ->method('createFulfillmentOrder')
            ->with($fbaOrderDTO)
            ->willReturn($createResponse);

        $this->fbaClient->expects($this->never())
            ->method('getFulfillmentOrder');

        // Assert
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage($errorMessage);

        // Act
        $this->service->ship($order, $buyer);
    }

    public function test_ship_calls_get_fulfillment_order_with_correct_seller_fulfillment_order_id(): void
    {
        // Arrange
        /** @var AbstractOrder&MockObject $order */
        $order = $this->createMock(AmazonOrder::class);
        /** @var BuyerInterface&MockObject $buyer */
        $buyer = $this->createMock(Buyer::class);
        $sellerFulfillmentOrderId = 'FBA202401161234567890';
        $expectedTrackingNumber = '1Z999AA10123456784';

        $fbaOrderDTO = $this->createMock(FBAFulfillmentOrderDTO::class);
        $fbaOrderDTO->expects($this->once())
            ->method('getSellerFulfillmentOrderId')
            ->willReturn($sellerFulfillmentOrderId);

        $createResponse = $this->createMock(CreateFulfillmentOrderResponse::class);
        $createResponse->expects($this->once())
            ->method('isSuccess')
            ->willReturn(true);

        $getResponse = $this->createMock(GetFulfillmentOrderResponse::class);
        $getResponse->expects($this->once())
            ->method('getTrackingNumber')
            ->willReturn($expectedTrackingNumber);

        $this->fbaOrderDTOFactory->expects($this->once())
            ->method('create')
            ->with($order, $buyer, $this->marketplaceId)
            ->willReturn($fbaOrderDTO);

        $this->fbaClient->expects($this->once())
            ->method('createFulfillmentOrder')
            ->with($fbaOrderDTO)
            ->willReturn($createResponse);

        $this->fbaClient->expects($this->once())
            ->method('getFulfillmentOrder')
            ->with($this->identicalTo($sellerFulfillmentOrderId))
            ->willReturn($getResponse);

        // Act
        $this->service->ship($order, $buyer);
    }

    public function test_ship_calls_factory_with_correct_parameters(): void
    {
        // Arrange
        /** @var AbstractOrder&MockObject $order */
        $order = $this->createMock(AmazonOrder::class);
        /** @var BuyerInterface&MockObject $buyer */
        $buyer = $this->createMock(Buyer::class);
        $sellerFulfillmentOrderId = 'FBA202401161234567890';
        $expectedTrackingNumber = '1Z999AA10123456784';

        $fbaOrderDTO = $this->createMock(FBAFulfillmentOrderDTO::class);
        $fbaOrderDTO->expects($this->once())
            ->method('getSellerFulfillmentOrderId')
            ->willReturn($sellerFulfillmentOrderId);

        $createResponse = $this->createMock(CreateFulfillmentOrderResponse::class);
        $createResponse->expects($this->once())
            ->method('isSuccess')
            ->willReturn(true);

        $getResponse = $this->createMock(GetFulfillmentOrderResponse::class);
        $getResponse->expects($this->once())
            ->method('getTrackingNumber')
            ->willReturn($expectedTrackingNumber);

        $this->fbaOrderDTOFactory->expects($this->once())
            ->method('create')
            ->with(
                $this->identicalTo($order),
                $this->identicalTo($buyer),
                $this->identicalTo($this->marketplaceId)
            )
            ->willReturn($fbaOrderDTO);

        $this->fbaClient->expects($this->once())
            ->method('createFulfillmentOrder')
            ->with($fbaOrderDTO)
            ->willReturn($createResponse);

        $this->fbaClient->expects($this->once())
            ->method('getFulfillmentOrder')
            ->with($sellerFulfillmentOrderId)
            ->willReturn($getResponse);

        // Act
        $this->service->ship($order, $buyer);
    }
}

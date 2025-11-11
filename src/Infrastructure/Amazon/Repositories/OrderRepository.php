<?php

declare(strict_types=1);

namespace App\Infrastructure\Amazon\Repositories;

use App\Domain\Entities\AbstractOrder;
use App\Domain\Entities\AmazonOrder;
use App\Domain\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function getOrderById(int $orderId): AbstractOrder
    {
        $amazonOrder = new AmazonOrder($orderId);
        $amazonOrder->load();

        return $amazonOrder;
    }
}

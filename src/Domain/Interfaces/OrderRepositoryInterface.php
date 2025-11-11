<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\Entities\AbstractOrder;

interface OrderRepositoryInterface
{
    public function getOrderById(int $orderId): AbstractOrder;
}

<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

interface ShipOrderServiceInterface
{
    public function handle(int $orderId, int $buyerId): string;
}

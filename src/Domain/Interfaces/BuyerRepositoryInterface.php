<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\Entities\BuyerInterface;

interface BuyerRepositoryInterface
{
    public function getBuyerById(int $buyerId): BuyerInterface;
}

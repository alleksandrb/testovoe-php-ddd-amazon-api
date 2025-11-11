<?php

declare(strict_types=1);

namespace App\Infrastructure\Amazon\Repositories;

use App\Domain\Entities\Buyer;
use App\Domain\Entities\BuyerInterface;
use App\Domain\Interfaces\BuyerRepositoryInterface;
use RuntimeException;

class BuyerRepository implements BuyerRepositoryInterface
{
    public function getBuyerById(int $buyerId): BuyerInterface
    {
        $buyerData = $this->loadBuyerData($buyerId);

        return new Buyer($buyerData);
    }

    private function loadBuyerData(int $buyerId): array
    {
        $buyerDataPath = __DIR__.'/../../../../mock/buyer.'.$buyerId.'.json';
        $normalizedPath = realpath($buyerDataPath);
        
        if ($normalizedPath === false || ! file_exists($normalizedPath)) {
            throw new RuntimeException('Buyer data not found for ID: '.$buyerId);
        }

        $buyerData = json_decode(file_get_contents($normalizedPath), true);
        if (! is_array($buyerData)) {
            throw new RuntimeException('Invalid buyer data for ID: '.$buyerId);
        }

        return $buyerData;
    }
}

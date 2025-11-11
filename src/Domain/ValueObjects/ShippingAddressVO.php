<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

/**
 * Value Object for Shipping Address information
 */
class ShippingAddressVO
{
    public function __construct(
        private readonly string $street,
        private readonly string $city,
        private readonly string $state,
        private readonly string $zip,
        private readonly string $country
    ) {
        if (empty($this->street)) {
            throw new \InvalidArgumentException('Shipping street address cannot be empty');
        }

        if (empty($this->city)) {
            throw new \InvalidArgumentException('Shipping city cannot be empty');
        }

        if (empty($this->state)) {
            throw new \InvalidArgumentException('Shipping state cannot be empty');
        }

        if (empty($this->zip)) {
            throw new \InvalidArgumentException('Shipping zip code cannot be empty');
        }

        if (empty($this->country)) {
            throw new \InvalidArgumentException('Shipping country cannot be empty');
        }

        // Validate country code format (should be 2-letter ISO code)
        if (strlen($this->country) !== 2) {
            throw new \InvalidArgumentException('Shipping country must be a 2-letter ISO code');
        }
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}

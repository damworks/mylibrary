<?php

namespace App\Model\Product;

use Pimcore\Model\DataObject\Concrete;

/**
 * Abstract class for all publications (Book, Comic, Magazine)
 */
abstract class AbstractPublication extends Concrete
{
    /**
     * Returns the publication type based on the class name
     */
    public function getPublicationType(): string
    {
        $className = static::class;
        $shortName = substr($className, strrpos($className, '\\') + 1);
        return strtolower($shortName);
    }

    /**
     * Returns the formatted price string including currency symbol
     */
    public function getFormattedPrice(): string
    {
        $price = $this->getPrice();
        $currency = $this->getCurrency() ?? 'EUR';

        if ($price === null || $price <= 0) {
            return 'N/A';
        }

        $symbols = [
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
            'JPY' => '¥',
            'CHF' => 'CHF'
        ];

        $symbol = $symbols[$currency] ?? $currency;

        if (in_array($currency, ['EUR', 'GBP'], true)) {
            // Europe: ex. 13,00 €
            return number_format($price, 2, ',', '.') . ' ' . $symbol;
        } else if ($currency === 'JPY') {
            // Japan: ex. ¥ 1,300 (no decimals)
            return $symbol . ' ' . number_format($price, 0, '', ',');
        } else {
            // USA and other: ex. $ 13.00
            return $symbol . ' ' . number_format($price, 2, '.', ',');
        }
    }

}

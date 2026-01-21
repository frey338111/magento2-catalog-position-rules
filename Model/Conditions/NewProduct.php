<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model\Conditions;

use Hmh\CatalogPositionRules\Api\RuleConditionInterface;
use Hmh\CatalogPositionRules\Model\Data\ConditionInfoDto;
use Magento\Catalog\Api\Data\ProductInterface;

class NewProduct implements RuleConditionInterface
{
    private const LABEL = 'New Product';
    private const TAG = 'new_product';

    public function getLabel(): string
    {
        return self::LABEL;
    }

    public function getTag(): string
    {
        return self::TAG;
    }

    public function isConditionMatch(ProductInterface $product, ConditionInfoDto $condition): bool
    {
        $fromDate = $product->getNewsFromDate();
        $toDate = $product->getNewsToDate();

        if (!$fromDate && !$toDate) {
            return false;
        }

        $now = time();
        if ($fromDate && $now < strtotime($fromDate)) {
            return false;
        }
        if ($toDate && $now > strtotime($toDate)) {
            return false;
        }

        return true;
    }
}

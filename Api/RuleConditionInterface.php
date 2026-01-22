<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Api;

use Magento\Catalog\Api\Data\ProductInterface;
use Hmh\CatalogPositionRules\Model\Data\ConditionInfoDto;

interface RuleConditionInterface
{
    /**
     * Get condition label.
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Get condition tag identifier.
     *
     * @return string
     */
    public function getTag(): string;

    /**
     * Check if condition matches the product.
     *
     * @param ProductInterface $product
     * @param ConditionInfoDto $condition
     * @return bool
     */
    public function isConditionMatch(ProductInterface $product, ConditionInfoDto $condition): bool;
}

<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Api;

use Magento\Catalog\Api\Data\ProductInterface;
use Hmh\CatalogPositionRules\Model\Data\ConditionInfoDto;

interface RuleConditionInterface
{
    public function getLabel(): string;

    public function getTag(): string;

    public function isConditionMatch(ProductInterface $product, ConditionInfoDto $condition): bool;
}

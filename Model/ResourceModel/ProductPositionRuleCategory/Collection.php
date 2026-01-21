<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRuleCategory;

use Hmh\CatalogPositionRules\Model\ProductPositionRuleCategory as ProductPositionRuleCategoryModel;
use Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRuleCategory as ProductPositionRuleCategoryResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(ProductPositionRuleCategoryModel::class, ProductPositionRuleCategoryResource::class);
    }
}
